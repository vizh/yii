<?php


class TestGate extends AbstractCommand
{
  protected function doExecute()
  {
    header('Content-type: text/json; charset=utf-8');

    $method = Yii::app()->getRequest()->getIsPostRequest() ? 'POST' : 'GET';

    $object = new stdClass();
    $object->Params = $_REQUEST;
    $object->Method = $method;
    $object->Users = array((object)array('rocID' => 2332, 'LastName' => 'Петров', 'FirstName' => 'Иван'),
                           (object)array('rocID' => 1195, 'LastName' => 'Иванов', 'FirstName' => 'Петр'));
    echo json_encode($object);
  }
}