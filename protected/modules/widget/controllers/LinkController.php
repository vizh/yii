<?php
class LinkController extends \widget\components\Controller
{
  public function actions()
  {
    return [
      'index' => '\widget\controllers\link\IndexAction',
      'cabinet' => '\widget\controllers\link\CabinetAction'
    ];
  }

} 