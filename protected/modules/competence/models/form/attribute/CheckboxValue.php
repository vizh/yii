<?php
namespace competence\models\form\attribute;

class CheckboxValue extends RadioValue
{
  public $isUnchecker;

  public function __construct($key = '', $title = '', $isOther = false, $sort = '', $isUnchecker = false, $description = '')
  {
    parent::__construct($key, $title, $isOther, $sort, $description);
    $this->isUnchecker = $isUnchecker;
  }
}