<?php
namespace competence\models\form\attribute;

class CheckboxValue extends RadioValue
{
  public $isUnchecker;

  public function __construct($key = '', $title = '', $isOther = false, $sort = '', $isUnchecker = false, $description = '', $suffix = '')
  {
    parent::__construct($key, $title, $isOther, $sort, $description, $suffix);
    $this->isUnchecker = $isUnchecker;
  }
}