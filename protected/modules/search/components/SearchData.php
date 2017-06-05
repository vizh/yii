<?php
namespace search\components;

class SearchData
{
    public $Title;
    public $Url;
    public $Image;

    public function getTitle()
    {
        return $this->Title;
    }

    public function getUrl()
    {
        return $this->Url;
    }

    public function getImage()
    {
        return $this->Image;
    }
}