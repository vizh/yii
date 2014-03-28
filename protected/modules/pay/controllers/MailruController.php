<?php
\Yii::import('ext.MailRuMoney.mailru-money', true);

class MailruController extends \pay\components\Controller
{
  public function actionIndex($eventIdName)
  {
    $startTime = time();
    $this->setPageTitle('Выставление счета Деньги Mail.Ru / ' .$this->getEvent()->Title . ' / RUNET-ID');
    if (!$this->getAccount()->MailRuMoney)
      throw new \CHttpException(404);

    $finder = \pay\components\collection\Finder::create($this->getEvent()->Id, $this->getUser()->Id);
    $collection = $finder->getUnpaidFreeCollection();
    if ($collection->count() == 0)
      $this->redirect($this->createUrl('/pay/cabinet/index'));

    $request = Yii::app()->getRequest();

    $email = '';
    $error = false;
    if ($request->getIsPostRequest())
    {
      $email = $request->getParam('Email');
      $emailValidator = new CEmailValidator();
      if ($emailValidator->validateValue($email))
      {
        $order = new \pay\models\Order();
        try
        {
          $total = $order->create($this->getUser(), $this->getEvent(), \pay\models\OrderType::MailRu);

          $mailRu = new MailRu_Money(\pay\components\systems\MailRu::ApiKey);
          $result = $mailRu->makeInvoice($email, number_format($total, 2, '.', ''), 'RUR', 'Оплата услуг на ' . $this->getEvent()->Title, $_SERVER['REMOTE_ADDR'], $order->Id);

          $order->refresh();
          $order->OrderJuridical->ExternalKey = $result;
          $order->OrderJuridical->save();

          while (time()-$startTime < 20)
          {
            sleep(1);
            $order->OrderJuridical->refresh();
            if ($order->OrderJuridical->UrlPay != null)
            {
              $this->redirect($order->OrderJuridical->UrlPay);
            }
          }
          $this->redirect($this->createUrl('/pay/mailru/wait', ['orderId' => $order->Id]));
        }
        catch (\Exception $e)
        {
          if (!$order->getIsNewRecord())
            $order->delete();
          if ($e->getCode() == MailRu_Money::ERR_API_NO_SUCH_USER)
          {
            $error = 'Пользователь, на email которого выставляется счет, не зарегистрирован в системе Деньги Mail.Ru.';
          }
          else
          {
            $error = 'Произошла ошибка при выставлении счета в системе Деньги Mail.Ru. Повторите попытку позже или напишите нам на email <a href="mailto:support@runet-id.com">support@runet-id.com</a>, для решения проблемы. Ошибка: ' . $e->getCode();
          }
        }
      }
      else
      {
        $error = 'Адрес введен некорректно.';
      }
    }

    $this->render('index', ['email' => $email, 'error' => $error]);
  }

  public function actionWait($orderId, $eventIdName)
  {
    $startTime = time();

    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $order = \pay\models\Order::model()->findByPk($orderId);
      if ($order == null)
        throw new CHttpException(404);

      while (time()-$startTime < 20)
      {
        sleep(1);
        $order->OrderJuridical->refresh();
        if ($order->OrderJuridical->UrlPay != null)
        {
          $this->redirect($order->OrderJuridical->UrlPay);
        }
      }
    }

    $this->render('wait');
  }
} 