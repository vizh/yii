<?php
namespace partner\controllers\user;

class EditAction extends \partner\components\Action
{
  /** @var \event\models\Event */
  public $event;

  /** @var \user\models\User */
  public $user;

  public $error;

  /** @var \event\models\Role[] */
  public $roles;

  /** @var \event\models\Day[] */
  public $days;

  public function run()
  {
    $this->initResources();
    $this->getController()->initActiveBottomMenu('edit');

    $request = \Yii::app()->request;
    $rocId = $request->getParam('rocId', 0);
    $this->user = \user\models\User::GetByRocid($rocId);
    $this->setTitle();

    if ($rocId == 0 && empty($this->user))
    {
      $rocId = intval($request->getParam('NameOrRocid'));
      $this->user = \user\models\User::GetByRocid($rocId);
      $this->setTitle();
    }

    if (empty($this->user))
    {
      if ($request->getIsPostRequest())
      {
        $this->error = 'Не удалось найти пользователя. Убедитесь, что все данные указаны правильно.';
      }
      $nameOrRocid = $request->getParam('NameOrRocid');
      $this->getController()->render('edit', array(
        'rocId' => $rocId,
        'nameOrRocid' => $nameOrRocid
      ));
    }
    else
    {
      if ($request->getQuery('rocId', null) == null)
      {
        $this->getController()->redirect(
          \Yii::app()->createUrl('/partner/user/edit',
            array('rocId' => $this->user->RocId)
          )
        );
      }
      $this->event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);
      $this->roles = \event\models\Role::GetAll();

      $doAction = $request->getParam('do');
      if ($doAction == 'deleteCoupon')
      {
        $couponActivation = $this->prepareCoupon();
        if (empty($couponActivation->OrderItems))
        {
          $couponActivation->delete();
          $this->getController()->redirect(
            \Yii::app()->createUrl('/partner/user/edit',
              array('rocId' => $this->user->RocId)
            )
          );
        }
      }

      $participants = $this->prepareParticipants();
      $couponActivation = $this->prepareCoupon();
      $orderItems = $this->prepareOrderItems();
      $this->getController()->render('edit-tabs',
        array(
          'participants' => $participants,
          'couponActivation' => $couponActivation,
          'orderItems' => $orderItems
        )
      );
    }
  }

  private function initResources()
  {
    $cs = \Yii::app()->clientScript;
    $cs->registerScriptFile(\Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/js/libs/jquery-ui-1.8.16.custom.min.js'), \CClientScript::POS_HEAD);

    $blitzerPath = \Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/css/blitzer');
    $cs->registerCssFile($blitzerPath . '/jquery-ui-1.8.16.custom.css');
    $cs->registerScriptFile(\Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/js/partner/user.edit.js'), \CClientScript::POS_HEAD);
  }

  private function setTitle()
  {
    if (!empty($this->user))
    {
      $this->getController()->setPageTitle('Добавление/редактирование участника мероприятия: ' . $this->user->GetFullName());
    }
    else
    {
      $this->getController()->setPageTitle('Добавление/редактирование участника мероприятия');
    }
  }


  private function prepareParticipants()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = 't.DayId';
    $participants = \event\models\Participant::model()->byEventId(\Yii::app()->partner->getAccount()->EventId)->byUserId($this->user->UserId)->findAll($criteria);

    $emptyParticipant = new \event\models\Participant();
    $emptyParticipant->DayId = null;
    $emptyParticipant->RoleId = 0;

    if (empty($this->event->Days))
    {
      $result = sizeof($participants) != 0 ? $participants :  array($emptyParticipant);
    }
    else
    {
      $result = array();
      foreach ($this->event->Days as $day)
      {
        $result[$day->DayId] = $emptyParticipant;
        $this->days[$day->DayId] = $day;
      }
      foreach ($participants as $participant)
      {
        $result[$participant->DayId] = $participant;
      }
    }

    return $result;
  }

  /**
   * @return \pay\models\CouponActivated
   */
  private function prepareCoupon()
  {
    return \pay\models\CouponActivated::model()->byUserId($this->user->UserId)->byEventId($this->event->EventId)->find();
  }

  /**
   * @return \pay\models\OrderItem[]
   */
  private function prepareOrderItems()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = 't.Deleted ASC';
    return \pay\models\OrderItem::model()->byOwnerId($this->user->UserId)->byEventId($this->event->EventId)->findAll($criteria);
  }

}