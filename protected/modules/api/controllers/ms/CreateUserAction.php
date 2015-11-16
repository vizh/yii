<?php
namespace api\controllers\ms;

use api\models\forms\user\MsRegister;
use event\models\Role;
use pay\models\Product;
use api\components\Action;

/**
 * Class CreateUserAction
 * @package api\controllers\ms
 *
 * @method \MsController getController()
 */
class CreateUserAction extends Action
{
    public function run()
    {
        $temporary = (bool) \Yii::app()->getRequest()->getParam('Temporary', false);
        $form = new MsRegister($this->getAccount(), $temporary);
        $form->fillFromPost();
        $user = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
        if ($user !== null) {
            $this->getEvent()->skipOnRegister = true;
            $this->getEvent()->registerUser($user, Role::model()->findByPk(24));

            $product = Product::model()->findByPk(4013);
            try {
                $product->getManager()->createOrderItem($user, $user);
            } catch (\Exception $e) {}

            $this->setResult([
                'PayUrl' => $this->getController()->getPayUrl($form->ExternalId)
            ]);
        }
    }


}