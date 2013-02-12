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
    $filter->attributes = $request->getParam('Filter');
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
    
    $page = $request->getParam('page', 1);
    if ($page <= 0)
    {
      $page = 1;
    }
    $allJobCount = \job\models\Job::model()->count($criteria);
    $criteria->limit = \Yii::app()->params['JobPerPage'];
    $criteria->offset = ($page - 1) * \Yii::app()->params['JobPerPage'];
    $criteria->order = '"t"."Id" DESC';
    
    $jobUp = null;
    if ($page == 1)
    {
      $criteriaUp = new \CDbCriteria();
      $criteriaUp->mergeWith($criteria);
      $criteriaUp->with = array('Job.Category', 'Job.Position', 'Job.Company');
      $criteriaUp->condition = str_replace('"t".', '"Job".', $criteria->condition);
      $criteriaUp->addCondition('"t"."StartTime" <= :Date AND ("t"."EndTime" >= :Date OR "t"."EndTime" IS NULL)');
      $criteriaUp->params['Date'] = date('Y-m-d H:i:s');
      $jobUp = \job\models\JobUp::model()->find($criteriaUp);
      if ($jobUp !== null)
      {
        $criteria->addCondition('"t"."Id" != '.$jobUp->JobId);
      }
    }
    $jobs = \job\models\Job::model()->findAll($criteria);
    $this->bodyId = 'jobs-page';
    $this->render('index', array(
      'filter' => $filter,
      'jobs'   => $jobs,
      'jobUp'  => $jobUp,
      'allJobCount' => $allJobCount
    ));
  }
}

?>
