<?php
class ListController extends \application\components\controllers\PublicMainController
{
  private $events = array();
  private $filter;
  private $month;
  private $year;
  
  public function beforeAction($action) 
  {
    $this->month = (int) \Yii::app()->request->getParam('Month', date('n'));
    $this->year  = (int) \Yii::app()->request->getParam('Year', date('Y'));
    if (empty($this->month) || empty($this->year)
      || ($this->month > 12 || $this->month < 1)
      ||!preg_match('/^\d{4}$/', $this->year))
    {
      throw new CHttpException(404);
    }
    
    $this->filter = new \event\models\forms\EventListFilterForm();
    
    $criteria = new \CDbCriteria();
    $criteria->condition = '("t"."StartYear" = :Year AND "t"."StartMonth" = :Month) OR ("t"."EndYear" = :Year AND "t"."EndMonth" = :Month)';
    $criteria->params = array(
      'Month' => $this->month,
      'Year' => $this->year,
    );
    $criteria->with = array(
      'LinkAddress'
    );
    $this->events = \event\models\Event::model()->byVisible()->findAll($criteria);
    return parent::beforeAction($action);
  }
  
  public function render($view, $data = array(), $return = false) 
  {
    $data += array(
      'events' => $this->events,
      'month' => $this->month,
      'year' => $this->year,
      'nextMonthUrl' => $this->getNextMonthUrl(),
      'prevMonthUrl' => $this->getPrevMonthUrl(),
      'filter' => $this->filter
    );
    parent::render($view, $data, $return);
  }

    /**
   * Возврщает ссылку на предыдущий месяц
   * @return type 
   */
  private function getPrevMonthUrl()
  {
    if ($this->month == 1)
    {
      $prevMonth = 12;
      $prevYear  = $this->year - 1;
    }
    else
    {
      $prevMonth = $this->month-1;
      $prevYear  = $this->year;
    }
    return $this->createUrl('/event/list/'.$this->action->getId(), array('Month' => $prevMonth, 'Year' => $prevYear));
  }
  
  /**
   * Возврщает ссылку на следующий месяц
   * @return type 
   */
  private function getNextMonthUrl()
  {
    if ($this->month == 12)
    {
      $nextMonth = 1;
      $nextYear  = $this->year + 1;
    }
    else
    {
      $nextMonth = $this->month+1;
      $nextYear  = $this->year;
    }
    return $this->createUrl('/event/list/'.$this->action->getId(), array('Month' => $nextMonth, 'Year' => $nextYear));
  }
  
  
  public function actionIndex()
  {
    $this->render('index');
  }
  
 
  
  public function actionCalendar()
  {
    $this->bodyId = 'events-calendar';
    $this->render('calendar');
  }
}
