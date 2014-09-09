<?php
namespace competence\models\test\runet2014;

trait MarketIndex
{
    public function getMarketIndex()
    {
        $parts = explode('\\', get_class($this));
        $class = array_pop($parts);
        $index = substr(strrchr($class, '_'), 1);
        return intval($index);
    }
} 