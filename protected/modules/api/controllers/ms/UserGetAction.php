<?php
namespace api\controllers\ms;

use api\components\Action;
use api\components\ms\Helper;

/**
 * Class UserGetAction
 * @package api\controllers\ms
 *
 * @method \MsController getController();
 */
class UserGetAction extends Action
{
    public function run()
    {
        $id = \Yii::app()->getRequest()->getParam('ExternalId', null);

        $externalUser = Helper::getExternalUserById($this->getAccount(), $id);
        $user = $externalUser->User;

        $builder = $this->getDataBuilder();
        $builder->createUser($user);
        $builder->buildUserEmployment($user);
        $data = $builder->buildUserEvent($user);

        $data->Hash = Helper::generatePayHash($externalUser);
        $data->PayUrl = Helper::getPayUrl($this->getAccount(), $user);
        $this->setResult($data);
    }
}
