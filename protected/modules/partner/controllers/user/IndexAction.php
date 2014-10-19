<?php
namespace partner\controllers\user;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Поиск участников мероприятия');
    $this->getController()->initActiveBottomMenu('index');

    $form = new \partner\models\forms\user\ParticipantSearch($this->getEvent());
    $reset = \Yii::app()->getRequest()->getParam('reset');
    if ($reset !== 'reset')
    {
      $form->attributes = \Yii::app()->getRequest()->getParam(get_class($form));
    }

    $criteria = $form->getCriteria();
    $count = \user\models\User::model()->count($criteria);
    $paginator = new \application\components\utility\Paginator($count, [], true);
    $paginator->perPage = \Yii::app()->params['PartnerUserPerPage'];
    $criteria->mergeWith($paginator->getCriteria());

    //$criteria->order = '"max"("Participants"."CreationTime") DESC';
    $users = \user\models\User::model()->findAll($criteria);
    $userIdList = array();
    $usersSort = array();
    foreach ($users as $user)
    {
      $userIdList[] = $user->Id;
      $usersSort[$user->Id] = null;
    }

    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."Id"', $userIdList);
    $criteria->with = array(
      'Participants' => array(
        'on' => '"Participants"."EventId" = :EventId',
        'params' => array('EventId' => $this->getEvent()->Id),
        'together' => true
      ),
      'Settings',
      'Employments',
      'LinkPhones',
      'Badges' => [
        'together' => false,
        'order' => '"Badges"."CreationTime" ASC',
        'with' => ['Operator'],
        'on' => '"Badges"."EventId" = :EventId',
        'params' => ['EventId' => $this->getEvent()->Id]
      ]
    );
    $users = \user\models\User::model()->findAll($criteria);
    foreach ($users as $user)
    {
      $usersSort[$user->Id] = $user;
    }

    /** @var $roles \event\models\Role[] */
    $roles = \event\models\Role::model()
        ->byEventId(\Yii::app()->partner->getAccount()->EventId)->findAll();

    $this->getController()->render('index',
      array(
          'event' => $this->getEvent(),
        'users' => $usersSort,
        'roles' => $roles,
        'paginator' => $paginator,
        'form' => $form,
        'showRuventsInfo' => ($form->Ruvents == 1)
      )
    );
  }
}