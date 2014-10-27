<?php
namespace event\widgets;

/**
 * Class Registration
 * @package event\widgets
 *
 * @property string $RegistrationAfterInfo
 * @property string $RegistrationBeforeInfo
 */
class Registration extends \event\components\Widget
{
  public function getAttributeNames()
  {
    return ['RegistrationAfterInfo', 'RegistrationBeforeInfo', 'RegistrationTitle', 'RegistrationBuyLabel'];
  }


  public function getIsHasDefaultResources()
  {
    return true;
  }

  public function process()
  {
    $request = \Yii::app()->getRequest();
    $product = $request->getParam('product', array());
    if ($request->getIsPostRequest() && sizeof($product) !== 0)
    {
      $this->getController()->redirect(\Yii::app()->createUrl('/pay/cabinet/register', ['eventIdName' => $this->event->IdName]));
    }
  }


  public function run()
  {
    /** @var $account \pay\models\Account */
    $account = \pay\models\Account::model()->byEventId($this->event->Id)->find();
    if ($account === null)
    {
      return;
    }

    /** @var \event\models\Participant $participant */
    $participant = null;
    if (!\Yii::app()->user->getIsGuest())
    {
      if (count($this->event->Parts) == 0)
      {
        $participant = \event\models\Participant::model()
            ->byUserId(\Yii::app()->user->getCurrentUser()->Id)->byEventId($this->event->Id)->find();
      }
      else
      {
        $participants = \event\models\Participant::model()->byUserId(\Yii::app()->user->getCurrentUser()->Id)->byEventId($this->event->Id)->findAll();
        foreach ($participants as $p)
        {
          if ($participant == null || $participant->Role->Priority < $p->Role->Priority)
          {
            $participant = $p;
          }
        }
      }
    }

    if ($account->ReturnUrl === null)
    {
      \Yii::app()->getClientScript()->registerPackage('runetid.event-calculate-price');
      $criteria = new \CDbCriteria();
      $criteria->order = '"t"."Priority" DESC, "t"."Id" ASC';
      $criteria->addCondition('"t"."ManagerName" != \'Ticket\'');
      $model = \pay\models\Product::model()->byPublic(true);
      if (!\Yii::app()->user->isGuest)
      {
        $model->byUserAccess(\Yii::app()->user->getCurrentUser()->Id, 'OR');
      }
      $products = $model->byEventId($this->event->Id)->findAll($criteria);

      $viewName = !$this->event->FullWidth ? 'registration' : 'fullwidth/registration';

      $this->render($viewName, [
        'products' => $products,
        'account' => $account,
        'participant' => $participant,
        'event' => $this->event
      ]);
    }
    else
    {
      $this->render('registration-external', [
        'account' => $account,
        'participant' => $participant
      ]);
    }
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Регистрация на мероприятии');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Content;
  }
}