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
    public function open()
    {
        parent::open();

        if (session_id() === '') {
            session_regenerate_id(true);
        }
    }


    public function writeSession($id, $data)
    {
        $data = str_replace('\\', '\\\\', $data);
        return parent::writeSession($id, $data);
    }
}