<?php
namespace event\components\handlers\register;

class Premiaru15 extends Base
{
    /**
     * @inheritdoc
     */
    public function getBody()
    {
        if ($this->role->Id !== 168 && $this->role->Id !== 14) {
            return null;
        }
        return parent::getBody();
    }

}