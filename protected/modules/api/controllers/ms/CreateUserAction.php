<?php
namespace api\controllers\ms;

use api\components\ms\forms\RegisterUser;
use application\helpers\Flash;
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
        $form = new RegisterUser($this->getAccount());
        $form->fillFromPost();
        $user = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
        if ($user !== null) {
            $this->getEvent()->skipOnRegister = true;
            $this->getEvent()->registerUser($user, Role::model()->findByPk(24));
            $product = Product::model()->findByPk(4019);
            try {
                $product->getManager()->createOrderItem($user, $user);
            } catch (\Exception $e) {}

            $this->setResult([
                'PayUrl' => 'http://msdevcon16.runet-id.com/fastauth?id=' . $user->RunetId . '&hash=' . $user->getHash()
            ]);
        }
    }


}