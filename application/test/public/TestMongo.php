<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 22.08.11
 * Time: 17:56
 * To change this template use File | Settings | File Templates.
 */

class TestMongo extends AbstractCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    //$this->insertFoo2();
    $this->myPrint();
  }

  protected function insertFoo2()
  {
    $m = new Mongo();
    $db = $m->selectDB('test');
    $collection = $db->selectCollection('foo2');

    $data = array('a1'=>3, 'a2'=>4);
    $data = (object)$data;
    $collection->insert(array('test' => array($data, $data, $data)));
  }

  protected function myPrint()
  {
    $m = new Mongo();
    $db = $m->selectDB('test');
    $collection = $db->selectCollection('foo2');

    $cursor = $collection->find();

    // iterate through the results
    foreach ($cursor as $obj) {
      print_r($obj);
    }
  }
}
