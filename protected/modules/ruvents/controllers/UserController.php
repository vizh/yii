<?php
class UserController extends \ruvents\components\Controller
{

  public function actions()
  {
    return array(
      'create' => 'ruvents\controllers\user\CreateAction',
      'edit' => 'ruvents\controllers\user\EditAction',
      'search' => 'ruvents\controllers\user\SearchAction'
    );
  }
}
