<?php
namespace partner\controllers\user;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Поиск участников мероприятия');
    $this->getController()->initBottomMenu('index');

    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId AND Settings.Visible = \'1\'';
    $criteria->params = array(
      ':EventId' => \Yii::app()->partner->getAccount()->EventId
    );
    $criteria->with = array(
      'User',
      'User.Employments',
      'User.Settings',
      'User.Employments.Company',
      'Role',
      'User.Emails',
      'User.Phones'
    );

    $request = \Yii::app()->request;

    $page = (int) $request->getParam('page', 0);
    if ($page <= 0)
    {
      $page = 1;
    }


    $filter = $request->getParam('filter', array());
    if (!empty ($filter))
    {
      foreach ($filter as $field => $value)
      {
        if ( !empty ($value))
        {
          switch ($field)
          {
            case 'RoleId':
              $criteria->addCondition('t.RoleId = :RoleId');
              $criteria->params[':RoleId'] = $value;
              break;

            case 'RocId':
              $criteria->addCondition('User.RocId = :RocId');
              $criteria->params[':RocId'] = $value;
              break;

            case 'Name':
              $nameParts = preg_split('/[, .]/', $value, -1, PREG_SPLIT_NO_EMPTY);
              if ( sizeof ($nameParts) == 1)
              {
                $criteria->addCondition(
                  'User.FirstName LIKE :NamePart0 OR User.LastName LIKE :NamePart0'
                );
                $criteria->params[':NamePart0'] = '%'. $nameParts[0] .'%';
              }
              else
              {
                $criteria->addCondition('
                              (User.FirstName LIKE :NamePart0 AND User.LastName LIKE :NamePart1) OR (User.FirstName LIKE :NamePart1 AND User.LastName LIKE :NamePart0)
                          ');
                $criteria->params[':NamePart0'] = '%'. $nameParts[0] .'%';
                $criteria->params[':NamePart1'] = '%'. $nameParts[1] .'%';
              }

              break;
          }
        }
      }
    }

    $criteria->group = 't.UserId';
    $count = \event\models\Participant::model()->count($criteria);
    // count(EventUser::model()->findAll($criteria));


    /** @var $event \event\models\Event */
    $event = \event\models\Event::model()->findByPk(\Yii::app()->partner->getAccount()->EventId);

    $criteria->limit  = \UserController::UsersOnPage;
    $criteria->offset = \UserController::UsersOnPage * ($page-1);


    $users = array();
    /** @var $participants \event\models\Participant[] */
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $users [$participant->UserId] = array(
        'Participant' => $participant
      );
      if ( !empty ($event->Days))
      {
        $users[$participant->UserId]['DayRoles'] = \event\models\Participant::model()->byUserId($participant->UserId)->byEventId($participant->EventId)->findAll('t.DayId IS NOT NULL');
      }
    }

    $roles = \event\models\Event::model()->findByPk(\Yii::app()->partner->getAccount()->EventId)->GetUsingRoles();



    $this->getController()->render('index',
      array(
        'users' => $users,
        'roles' => $roles,
        'event' => $event,
        'filter' => $filter,
        'count' => $count,
        'page' => $page
      )
    );
  }
}