<?php
class UtilityController extends ruvents\components\Controller
{
  public function actionPing () 
  {
    $result = new stdClass();
    $result->Result = true;
    echo json_encode($result);
  }
}