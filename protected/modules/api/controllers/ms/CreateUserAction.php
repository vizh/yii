<?php
namespace api\controllers\ms;

use api\models\forms\user\MsRegister;
use api\models\forms\user\Register;
use event\models\Role;
use pay\models\Product;

/**
 * Class CreateUserAction
 * @package api\controllers\ms
 *
 * @method \MsController getController()
 */
class CreateUserAction extends \api\components\Action
{
    public function run()
    {
        $form = new MsRegister($this->getAccount());
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
                'PayUrl' => 'http://msdevcon16.runet-id.com/?id=' . $form->ExternalId . '&hash=' . $this->getController()->generatePayHash($form->ExternalId)
            ]);
        }
    }


}