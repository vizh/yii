<?php
namespace api\controllers\ms;

use api\components\Action;

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
        $user = $this->getController()->getExternalUser($id)->User;
        $builder = $this->getDataBuilder();
        $builder->createUser($user);
        $builder->buildUserEmployment($user);
        $data = $builder->buildUserEvent($user);
        $data->Hash = $this->getController()->generatePayHash($id);
        $data->PayUrl = $this->getController()->getPayUrl($id);
        $this->setResult($data);
    }
}
