<?php
namespace competence\models\test\runet2014;

trait MarketIndex
{
    private $marketIndex = null;

    public function getMarketIndex()
    {
        if ($this->marketIndex === null) {
            $parts = explode('\\', get_class($this));
            $class = array_pop($parts);
            $this->marketIndex = substr(strrchr($class, '_'), 1);
            $this->marketIndex = intval($this->marketIndex);
        }
        return $this->marketIndex;
    }
} 