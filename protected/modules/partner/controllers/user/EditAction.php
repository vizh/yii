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

  public function run()
  {
    $this->initResources();

    $request = \Yii::app()->request;
    $rocId = $request->getParam('rocId', 0);
    $this->user = \user\models\User::GetByRocid($rocId);

    $this->setTitle();

    $this->event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);
    $this->roles = \event\models\Role::GetAll();

    if (empty($this->event->Days))
    {
      $this->runSingleDayEvent();
    }
    else
    {
      $this->runMultipleDayEvent();
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


  private function runSingleDayEvent()
  {
    $participant = null;
    if ( !empty ($this->user))
    {
      $participant = \event\models\Participant::GetByUserEventId($this->user->UserId, \Yii::app()->partner->getAccount()->EventId);
    }

    $request = \Yii::app()->request;
    if ($request->getIsPostRequest())
    {
      if (!empty ($this->user))
      {
        $roleId = (int) $request->getParam('RoleId');

        if ($roleId == 0 && !empty($participant))
        {
          $participant->delete();
        }
        elseif ($roleId != 0)
        {
          $role = \event\models\Role::GetById($roleId);
          if ( empty ($participant))
          {
            $participant = $this->event->RegisterUser($this->user, $role);
          }
          else
          {
            $participant->UpdateRole($role);
          }
        }
      }
      else
      {
        $this->error = 'Не удалось найти пользователя. Убедитесь, что все данные указаны правильно.';
      }
    }


    $this->getController()->render('edit-single-day',
      array(
        'participant' => $participant
      )
    );
  }

  private function runMultipleDayEvent()
  {
    $request = \Yii::app()->request;
    if ($request->getIsPostRequest())
    {

      if ( !empty ($this->user))
      {
        $roleIds = $request->getParam('RoleId');
        if (is_array($roleIds))
        {
          foreach ($roleIds as $dayId => $roleId)
          {
            $participant = \event\models\Participant::model()
              ->byEventId( \Yii::app()->partner->getAccount()->EventId)
              ->byDayId($dayId)
              ->byUserId($this->user->UserId)->find();

            if ($roleId != 0)
            {
              $role = \event\models\Role::GetById($roleId);
              if ($participant != null)
              {
                $participant->UpdateRole($role);
              }
              else
              {
                $eventDay = \event\models\Day::model()->findByPk($dayId);
                $this->event->RegisterUserOnDay($eventDay, $this->user, $role);
              }
            }
            else if ($roleId == 0 && $participant != null)
            {
              $participant->delete();
            }
          }
        }
      }
      else
      {
        $this->error = 'Не удалось найти пользователя. Убедитесь, что все данные указаны правильно.';
      }
    }

    $participantRolesIdByDay = array();
    if ( !empty ($this->user))
    {
      $participantsOnDay = \event\models\Participant::model()->byEventId(\Yii::app()->partner->getAccount()->EventId)->byUserId($this->user->UserId)->findAll();
      foreach ($participantsOnDay as $participant)
      {
        $participantRolesIdByDay[$participant->DayId] = $participant->RoleId;
      }
    }


    $this->getController()->render('edit-multiple-day', array('participantRolesIdByDay' => $participantRolesIdByDay));
  }
}