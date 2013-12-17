<?php
namespace mail\controllers\admin\template;


class IndexAction extends \CAction
{
  public function run()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Id" DESC';
    $paginator = new \application\components\utility\Paginator(
      \mail\models\Template::model()->count($criteria)
    );
    $paginator->perPage = \Yii::app()->getParams()['AdminMailPerPage'];
    $criteria->mergeWith($paginator->getCriteria());
    $templates = \mail\models\Template::model()->findAll($criteria);
    $this->getController()->setPageTitle(\Yii::t('app', 'Список рассылок'));
    $this->getController()->render('index', ['templates' => $templates, 'paginator' => $paginator]);
  }
}