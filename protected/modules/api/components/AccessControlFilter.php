<?php
namespace api\components;

class AccessControlFilter extends \application\components\auth\AccessControlFilter
{
    protected function getUser()
    {
        return WebUser::Instance();
    }
}