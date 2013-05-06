<?php
namespace partner\controllers\user;

class EditAction extends \partner\components\Action
{
  /** @var \user\models\User */
  public $user = null;

  public $error;

  /** @var \event\models\Role[] */
  public $roles;

  public function run()
  {
    $this->getController()->initActiveBottomMenu('edit');

    $request = \Yii::app()->request;
    $runetId = $request->getParam('runetId');
    $name = $request->getParam('name');
    if ((int)$runetId === 0)
    {
      $runetId = (int)$name;
    }
    $this->user = \user\models\User::model()->byRunetId($runetId)->find();
    $this->setTitle();

    if ($this->user === null)
    {
      if ($request->getIsPostRequest())
      {
        $this->error = 'Не удалось найти пользователя. Убедитесь, что все данные указаны правильно.';
      }
      $this->getController()->render('edit', array(
        'runetId' => $runetId,
        'name' => $name
      ));
    }
    else
    {
      if ($request->getQuery('runetId', null) == null)
      {
        $this->getController()->redirect(
          \Yii::app()->createUrl('/partner/user/edit',
            array('runetId' => $this->user->RunetId)
          )
        );
      }

      $criteria = new \CDbCriteria();
      $criteria->order = '"t"."Id"';
      $this->roles = \event\models\Role::model()->findAll($criteria);

      $doAction = $request->getParam('do');
      if (!empty($doAction))
      {
        $this->processParticipants($doAction);
      }

      $participants = $this->prepareParticipants();
      $this->getController()->render('edit-tabs',
        array(
          'user' => $this->user,
          'event' => $this->getEvent(),
          'roles' => $this->roles,
          'participants' => $participants
        )
      );
    }
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

  /**
   * @return \event\models\Participant[]
   */
  private function prepareParticipants()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."PartId"';
    $participants = \event\models\Participant::model()->byEventId($this->getEvent()->Id)->byUserId($this->user->Id)->findAll($criteria);

    if (sizeof($this->getEvent()->Parts) > 0)
    {
      $result = array();
      foreach ($participants as $participant)
      {
        $result[$participant->PartId] = $participant;
      }
    }
    else
    {
      $result = $participants;
    }

    return $result;
  }

  private function processParticipants($doAction)
  {
    if ($doAction === 'changeParticipant')
    {
      $result = array();
      $request = \Yii::app()->getRequest();

      $roleId = $request->getParam('roleId');
      $partId = $request->getParam('partId');

      /** @var $role \event\models\Role */
      $role = \event\models\Role::model()->findByPk($roleId);
      if ($role !== null)
      {
        if (sizeof($this->getEvent()->Parts) == 0)
        {
          $this->getEvent()->registerUser($this->user, $role);
        }
        else
        {
          $part = \event\models\Part::model()->findByPk($partId);
          if ($part !== null)
          {
            $this->getEvent()->registerUserOnPart($part, $this->user, $role);
          }
          else
          {
            $result['error'] = true;
          }
        }
      }
      else
      {
        if ((int)$roleId == 0)
        {
          if (sizeof($this->getEvent()->Parts) == 0)
          {
            $this->getEvent()->unregisterUser($this->user);
          }
          else
          {
            $part = \event\models\Part::model()->findByPk($partId);
            if ($part !== null)
            {
              $this->getEvent()->unregisterUserOnPart($part, $this->user);
            }
            else
            {
              $result['error'] = true;
            }
          }
        }
        else
        {
          $result['error'] = true;
        }
      }
      echo json_encode($result);
      \Yii::app()->end();
    }
  }
}