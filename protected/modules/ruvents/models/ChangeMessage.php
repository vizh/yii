<?php
namespace ruvents\models;

class ChangeMessage
{
    public $key;
    public $from;
    public $to;

    public function __construct($key, $from, $to)
    {
        $this->key = $key;
        $this->from = $from;
        $this->to = $to;
    }
}
