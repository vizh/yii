<?php
class UtilityController extends ruvents\components\Controller
{
  public function actionPing () 
  {
    $result = new stdClass();
    $result->Success = true;
    echo json_encode($result);
  }
}