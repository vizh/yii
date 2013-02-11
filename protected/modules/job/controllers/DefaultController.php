<?php
class DefaultController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Category', 'Position', 'Company'
    );
    
    $request = \Yii::app()->getRequest();
    $filter = new \job\models\form\ListFilterForm();
    $filter->attributes = $request->getParam(get_class($filter));
    if ($filter->validate())
    {
      foreach ($filter->attributes as $attribute => $value)
      {
        if (!empty($value))
        {
          switch($attribute)
          {
            case 'CategoryId':
              $criteria->addCondition('"Category"."Id" = :CategoryId');
              $criteria->params['CategoryId'] = $value;
              break;
            
            case 'PositionId':
              $criteria->addCondition('"Position"."Id" = :PositionId');
              $criteria->params['PositionId'] = $value;
              break;
            
            case 'SalaryFrom':
              $criteria->addCondition('"t"."SalaryFrom" >= :SalaryFrom');
              $criteria->params['SalaryFrom'] = $value;
              break;
            
            case 'Query':
              $criteria->addCondition('to_tsvector("t"."Title") @@ plainto_tsquery(:Query)');
              $criteria->params['Query'] = $value;
              break;
          }
        }
      }
    }
    
    $page = $request->getParam('page');
    if ($page <= 0)
    {
      $page = 1;
    }
    $criteria->limit = $page * \Yii::app()->params['JobPerPage'];
    $criteria->offset = ($page - 1) * \Yii::app()->params['JobPerPage'];
     
    $jobs = \job\models\Job::model()->findAll($criteria);
    
    if ($page == 1 && !empty($jobs))
    {
      $criteria->with = array('Job.Category', 'Job.Position', 'Job.Company');
      $criteria->condition = str_replace('"t".', '"Job".', $criteria->condition);
      $criteria->addCondition('"t"."StartTime" <= :Date AND "t"."EndTime" >= :Date');
      $criteria->params['Date'] = date('Y-m-d H:i:s');
      $jobUp = \job\models\JobUp::model()->find($criteria);
    }
    
    $this->bodyId = 'jobs-page';
    $this->render('index', array(
      'filter' => $filter,
      'jobs'   => $jobs,
      'jobUp'  => $jobUp
    ));
  }
}

?>
