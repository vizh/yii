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
      $editFormModel = new \partner\components\form\UserPersonalEditForm();
      $editFormModel->attributes = $request->getParam(get_class($editFormModel));

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
      elseif ($doAction == 'editUser')
      {
        $this->editUser($editFormModel);;
      }
      elseif ($doAction == 'changeOption')
      {
        $this->changeOption();
      }

      if (\Yii::app()->partner->getAccount()->EventId == 391)
      {
        $locales = \Yii::app()->params['locales'];
        $employment = $this->user->GetPrimaryEmployment();
        foreach ($locales as $locale)
        {
          $this->user->setLocale($locale);
          foreach ($this->user->getTranslationFields() as $field)
          {
            $editFormModel->{$field}[$locale] = $this->user->$field;
          }

          if (!empty($employment))
          {
            $employment->Company->setLocale($locale);
            $editFormModel->CompanyName[$locale] = $employment->Company->Name;
            $editFormModel->CompanyId = $employment->Company->CompanyId;
            $employment->Company->resetLocale();
          }
        }
        $this->user->resetLocale();

        $option1 = \pay\models\Product::GetById(729);
        $optionOrderItem1 = \pay\models\OrderItem::model()
          ->byPayerId($this->user->UserId)
          ->byOwnerId($this->user->UserId)
          ->byProductId($option1->ProductId)->find();

        $option2 = \pay\models\Product::GetById(730);
        $optionOrderItem2 = \pay\models\OrderItem::model()
          ->byPayerId($this->user->UserId)
          ->byOwnerId($this->user->UserId)
          ->byProductId($option2->ProductId)->find();
      }
      else
      {
        $locales = array();
        $option1 = null;
        $optionOrderItem1 = null;
        $option2 = null;
        $optionOrderItem2 = null;
      }


      $participants = $this->prepareParticipants();
      $couponActivation = $this->prepareCoupon();
      $orderItems = $this->prepareOrderItems();
      $this->getController()->render('edit-tabs',
        array(
          'participants' => $participants,
          'couponActivation' => $couponActivation,
          'orderItems' => $orderItems,
          'editFormModel' => $editFormModel,
          'locales' => $locales,
          'option1' => $option1,
          'optionOrderItem1' => $optionOrderItem1,
          'option2' => $option2,
          'optionOrderItem2' => $optionOrderItem2
        )
      );
    }
  }

  /**
   * @param \partner\components\form\UserPersonalEditForm $editForm
   */
  private function editUser($editForm)
  {
    $locales = \Yii::app()->params['locales'];
    $request = \Yii::app()->getRequest();
    $editForm->attributes = $request->getParam(get_class($editForm));

    $employment = $this->user->GetPrimaryEmployment();
    foreach ($locales as $locale)
    {
      $this->user->setLocale($locale);
      foreach ($this->user->getTranslationFields() as $field)
      {
        $this->user->$field = $editForm->{$field}[$locale];
      }

      if (!empty($employment) && $employment->Company->CompanyId == $editForm->CompanyId)
      {
        $employment->Company->setLocale($locale);
        $employment->Company->Name = $editForm->CompanyName[$locale];
      }
    }
    $this->user->resetLocale();
    $this->user->UpdateTime = time();
    $this->user->save(false);
    if (!empty($employment) && $employment->Company->CompanyId == $editForm->CompanyId)
    {
      $employment->Company->resetLocale();
      $employment->Company->save();
    }

  }

  private function changeOption()
  {
    $products = array(729, 730);
    $productId = \Yii::app()->getRequest()->getParam('productId');
    if (in_array($productId, $products))
    {
      $option = \pay\models\Product::GetById($productId);
      /** @var $optionOrderItem \pay\models\OrderItem */
      $optionOrderItem = \pay\models\OrderItem::model()
        ->byPayerId($this->user->UserId)
        ->byOwnerId($this->user->UserId)
        ->byProductId($option->ProductId)->find();

      $status = \Yii::app()->getRequest()->getParam('status');
      if ($status == 1)
      {
        if (empty($optionOrderItem))
        {
          $optionOrderItem = new \pay\models\OrderItem();
          $optionOrderItem->PayerId = $this->user->UserId;
          $optionOrderItem->OwnerId = $this->user->UserId;
          $optionOrderItem->ProductId = $option->ProductId;
          $optionOrderItem->CreationTime = date('Y-m-d H:i:s');
        }
        $optionOrderItem->Paid = 1;
        $optionOrderItem->PaidTime = date('Y-m-d H:i:s');
        $optionOrderItem->Deleted = 0;
        $optionOrderItem->save();
      }
      else
      {
        if (!empty($optionOrderItem))
        {
          $optionOrderItem->PaidTime = null;
          $optionOrderItem->Paid = 0;
          $optionOrderItem->Deleted = 1;
          $optionOrderItem->save();
        }
      }

      echo json_encode(array('success' => true));
    }
    else
    {
      echo json_encode(array('success' => false));
    }


    \Yii::app()->end();
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