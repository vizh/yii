<?php
namespace event\components\handlers\register\system;

class Nspk15 extends Base
{
    public function getFrom()
    {
        return 'info@runet-id.com';
    }

    public function getTo()
    {
        return 'orgcenter@nspk.ru';
    }

    public function getBody()
    {
        if ($this->role->Id == 1) {
            return null;
        }
        return parent::getBody();
    }

} 