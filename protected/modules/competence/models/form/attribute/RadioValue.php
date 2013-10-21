<?php
namespace competence\models\form\attribute;

class RadioValue
{
  public $key;
  public $title;
  public $isOther;
  public $sort;

  public function __construct($key = '', $title = '', $isOther = false, $sort = '')
  {
    $this->key = $key;
    $this->title = $title;
    $this->isOther = $isOther;
    $this->sort = $sort;
  }
}