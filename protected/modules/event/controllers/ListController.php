<?php
class ListController extends \application\components\controllers\PublicMainController
{
  private $events = array();
  private $month;
  private $year;
  public function beforeAction($action) {
    $this->month = (int) \Yii::app()->request->getParam('Month');
    $this->year  = (int) \Yii::app()->request->getParam('Year');
    if (empty($this->month) || empty($this->year)
      || ($this->month > 12 || $this->month < 1)
      ||!preg_match('/^\d{4}$/', $this->year))
    {
      throw new CHttpException(404);
    }
    $criteria = new \CDbCriteria();
    $criteria->condition = '("t"."StartYear" = :Year AND "t"."StartMonth" = :Month) OR ("t"."EndYear" = :Year AND "t"."EndMonth" = :Month)';
    $criteria->params = array(
      'Month' => $this->month,
      'Year' => $this->year,
    );
    $this->events = \event\models\Event::model()->byVisible()->findAll($criteria);
    return parent::beforeAction($action);
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
    $this->render('index', array(
      'events' => $this->events,
      'month' => $this->month,
      'year' => $this->year,
      'nextMonthUrl' => $this->getNextMonthUrl(),
      'prevMonthUrl' => $this->getPrevMonthUrl()
    ));
  }
  
  public function actionCalendar()
  {
    
  }
}
