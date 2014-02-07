<?php
class ListController extends \application\components\controllers\AdminMainController
{
  public function actionIndex()
  {
    $models = ['User' => new \user\models\User()];
    $criteries = [
      'User' => new \CDbCriteria(),
      'Companies' => new \CDbCriteria()
    ];
    $criteries['User']->order = '"t"."RunetId" ASC';
    $criteries['User']->with  = ['Settings'];
    $criteries['Companies']->order = '"t"."Id" ASC';

    $query = \Yii::app()->getRequest()->getParam('Query');

    if ($query !== null)
    {
      if (strstr($query, '@'))
      {
        $criteries['User']->addCondition('"t"."Email" ILIKE :Email');
        $criteries['User']->params['Email'] = '%'.$query.'%';
      }
      elseif (is_numeric($query))
      {
        $criteries['User']->addCondition('"t"."RunetId" = :RunetId');
        $criteries['User']->params['RunetId'] = $query;
      }
      else
      {
        $models['Companies'] = new \company\models\Company();
        $criteries['User']->mergeWith(\user\models\User::model()->bySearch($query, null, true, false)->getDbCriteria());
        $criteries['Companies']->mergeWith(\company\models\Company::model()->bySearch($query)->getDbCriteria());
      }
    }

    $counts = [];
    foreach ($models as $key => $model)
    {
      $counts[$key] = $model->count($criteries[$key]);
    }

    $results = [];
    $paginator = new \application\components\utility\Paginator(array_sum($counts));

    $offset = $paginator->getOffset();
    $limit  = $paginator->perPage;
    $count  = 0;
    foreach ($models as $key => $model)
    {
      $count += $counts[$key];
      if ($count > $offset)
      {
        $criteries[$key]->limit  = $limit;
        $criteries[$key]->offset = $offset;
        $results = array_merge($results, $models[$key]->findAll($criteries[$key]));
        $limit  -= sizeof($results);
        $offset  = 0;
      }
      else
        $offset = $paginator->getOffset() - $counts[$key];

      if ($limit == 0)
        break;
    }
    $this->render('index', ['results' => $results, 'paginator' => $paginator]);
  }
}