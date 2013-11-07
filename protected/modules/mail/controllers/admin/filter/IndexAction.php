<?php
namespace mail\controllers\admin\filter;


class IndexAction extends \CAction
{
  public function run()
  {

//    $filter = new \mail\components\filter\Event();
//    $filter->positive[] = new \mail\components\filter\EventCondition(425, [2]);
//    $filter->negative[] = new \mail\components\filter\EventCondition(425, [2]);

    $filter = unserialize('O:28:"mail\components\filter\Event":2:{s:8:"positive";a:1:{i:0;O:37:"mail\components\filter\EventCondition":2:{s:7:"eventId";i:425;s:5:"roles";a:1:{i:0;i:2;}}}s:8:"negative";a:1:{i:0;O:37:"mail\components\filter\EventCondition":2:{s:7:"eventId";i:425;s:5:"roles";a:1:{i:0;i:2;}}}}');


    //echo serialize($filter);


    $model = \user\models\User::model();

    $count = $model->count($filter->getCriteria());

    echo $count;
    exit;
    $this->getController()->render('index');
  }
}