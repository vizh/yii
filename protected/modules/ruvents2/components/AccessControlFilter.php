<?php
namespace ruvents2\components;

class AccessControlFilter extends \application\components\auth\AccessControlFilter
{
    protected function getUser()
    {
        return WebUser::Instance();
    }

    protected function accessDenied($user, $message)
    {
        try {
            parent::accessDenied($user, $message);
        } catch (\CHttpException $e) {
            if ($e->statusCode === 403) {
                throw new Exception(Exception::ACCESS_DENIED);
            } else {
                throw $e;
            }
        }
    }
}