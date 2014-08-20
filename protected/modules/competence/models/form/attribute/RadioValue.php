<?php
namespace competence\models\form\attribute;

class RadioValue
{
    public $key;
    public $title;
    public $isOther;
    public $sort;
    public $description;

    public function __construct($key = '', $title = '', $isOther = false, $sort = '', $description = '')
    {
        $this->key = $key;
        $this->title = $title;
        $this->isOther = $isOther;
        $this->sort = $sort;
        $this->description = $description;
    }
}