<?php


class JuridicalController extends \pay\components\Controller
{
  public function actions()
  {
    return array(
      'create' => 'pay\controllers\juridical\CreateAction',
    );
  }
}
