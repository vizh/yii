<?php
class VisitController extends \ruvents\components\Controller
{

  public function actions()
  {
    return [
      'halls' => '\ruvents\controllers\visit\HallsAction',
      'create' => '\ruvents\controllers\visit\CreateAction'
    ];
  }
} 