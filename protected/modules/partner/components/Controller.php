<?php
namespace partner\components;


class Controller extends \application\components\controllers\BaseController
{
  public $layout = '//layouts/public';

  public function filters()
  {
    $filters = parent::filters();
    return array_merge(
      $filters,
      array(
        'checkAccess',
        'checkEventId'
      )
    );
  }

  public function filterCheckAccess($filterChain)
  {

  }

  public function filterCheckEventId($filterChain)
  {

  }
}