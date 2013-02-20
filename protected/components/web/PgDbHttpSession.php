<?php
namespace application\components\web;

class PgDbHttpSession extends \CDbHttpSession
{
//  public function readSession($id)
//  {
//    echo $id;
//    $data = parent::readSession($id);
//    var_dump($data);
//    return $data;
//  }


  public function writeSession($id, $data)
  {
    $data = str_replace('\\', '\\\\', $data);
    return parent::writeSession($id, $data);
  }
}