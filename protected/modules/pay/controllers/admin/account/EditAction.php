<?php
namespace pay\controllers\admin\account;

class EditAction extends \CAction
{
  public function run($accountId = null)
  {
    if ($accountId == null)
    {
      $account = new \pay\models\Account();
    }
    else
    {
      $account = \pay\models\Account::model()->findByPk($accountId);
      if ($account == null)
      {
        throw new \CHttpException(404);
      }
    }

    $form = new \pay\models\forms\admin\Account($account);
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $form->attributes = $request->getParam(get_class($form));
      $form->OfferFile  = \CUploadedFile::getInstance($form, 'OfferFile');
      if ($form->validate())
      {
        if ($account->getIsNewRecord())
        {
          $account->EventId = $form->EventId;
        }
        $account->Own = $form->Own == 1 ? true : false;
        if (!empty($form->ReceiptTemplateId))
        {
          $account->ReceiptTemplateId = $form->ReceiptTemplateId;
          $account->ReceiptEnable = true;
        }
        else
        {
          $account->ReceiptTemplateId = null;
          $account->ReceiptEnable = false;
        }

        if (!empty($form->OrderTemplateId))
        {
          $account->OrderTemplateId = $form->OrderTemplateId;
          $account->OrderEnable = true;
        }
        else
        {
          $account->OrderTemplateId = null;
          $account->OrderEnable = false;
        }

        $account->ReturnUrl = !empty($form->ReturnUrl) ? $form->ReturnUrl : null;
        if ($form->OfferFile !== null)
        {
          $offerName = strtolower($account->Event->IdName).substr($form->OfferFile->getName(), strrpos($form->OfferFile->getName(), '.'), strlen($form->OfferFile->getName()));
          $form->OfferFile->saveAs($form->getOfferPath().'/'.$offerName);
          $form->Offer = $offerName;
        }
        $account->Offer = !empty($form->Offer) ? $form->Offer : null;
        $account->OrderLastTime = !empty($form->OrderLastTime) ? \Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $form->OrderLastTime).' 23:59:59' : null;
        $account->ReceiptLastTime = !empty($form->ReceiptLastTime) ? \Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $form->ReceiptLastTime).' 23:59:59' : null;
        $account->Uniteller = $form->Uniteller == 1 ? true : false;
          $account->UnitellerRuvents = $form->UnitellerRuvents == 1 ? true : false;
        $account->PayOnline = $form->PayOnline == 1 ? true : false;
        $account->MailRuMoney = $form->MailRuMoney == 1 ? true : false;
        $account->save();
        \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Данные платежного аккаунта успешно сохранены!'));
        $this->getController()->redirect(
          $this->getController()->createUrl('/pay/admin/account/edit', ['accountId' => $account->Id])
        );
      }
    }
    elseif (!$account->getIsNewRecord())
    {
      foreach ($account->getAttributes() as $attr => $value)
      {
        if (property_exists($form, $attr) && !empty($value))
        {
          switch ($attr)
          {
            case 'OrderLastTime':
            case 'ReceiptLastTime':
              $form->$attr = \Yii::app()->getDateFormatter()->format('dd.MM.yyyy', $value);
              break;

            default:
                $form->$attr = $value;
              break;
          }
        }
      }
      $form->EventTitle = $account->Event->Title;
    } else {
        $form->UnitellerRuvents = true;
    }
    
    $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование платежного аккаунта'));
    $this->getController()->render('edit', ['form' => $form]);
  }
}
