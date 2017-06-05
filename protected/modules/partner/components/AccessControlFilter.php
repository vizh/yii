<?php
namespace partner\components;

class AccessControlFilter extends \application\components\auth\AccessControlFilter
{
    protected function getUser()
    {
        return \Yii::app()->partner;
    }
}