<?php
namespace competence\models\test\runet2014;

use competence\models\form\Textarea;

class C10A extends Textarea
{
    use RouteMarket;

    public function getPrev()
    {
        
    }

    public function getNext()
    {
        return $this->getNextMarketQuestion($this->getQuestion()->Test);
    }
} 