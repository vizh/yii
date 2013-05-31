<?php
namespace event\widgets;

class Users extends \event\components\Widget
{
  public $criteria = null;
  public $showCounter = true;
  public $showPagination = false;
  
  private $users = null;
  private $paginator = null;
  private function getUsers()
  {
    if ($this->users == null)
    {
      $userModel = \user\models\User::model()->byEventId($this->event->Id)->byVisible();
      $mainCriteria = new \CDbCriteria($userModel->getDbCriteria());
      $mainCriteria->order = $this->showCounter ? '"Participants"."CreationTime" DESC' : '"t"."LastName" ASC';
 
      if ($this->criteria !== null)
      {
        $mainCriteria->mergeWith($this->criteria);
      }

      $criteria = new \CDbCriteria();
      $criteria->mergeWith($mainCriteria);
      $criteria->with['Participants']['select'] = false;  
      $criteria->select = '"t"."Id", "t"."RunetId"';
 
      $this->paginator = new \application\components\utility\Paginator($userModel->count($criteria));
      $this->paginator->perPage = \Yii::app()->params['EventViewUserPerPage'];
      if (!$this->showCounter)
      {
        $this->paginator->perPage *= 2;
      }
      
      $userIdList = array_slice(
        \CHtml::listData($userModel->findAll($criteria), 'Id', 'RunetId'), 
        ($this->paginator->page - 1) * $this->paginator->perPage, 
        $this->paginator->perPage
      );
      
      $mainCriteria->addInCondition('"t"."RunetId"', $userIdList);
      $mainCriteria->with = array_merge($mainCriteria->with, array(
        'Settings', 'Employments', 'Participants.Role'
      ));
      $this->users = $userModel->findAll($mainCriteria);
    }
    return $this->users;
  }
  
  private function getPaginator()
  {
    return $this->paginator;
  }
  
  
  public function run()
  {
    $this->render('users', array('users' => $this->getUsers(), 'paginator' => $this->getPaginator()));
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Список участников');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }

  /**
   * 
   * @return bool
   */
  public function getIsActive()
  {
    return sizeof($this->getUsers()) > 0;
  }
}
