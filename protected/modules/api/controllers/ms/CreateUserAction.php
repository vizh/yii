<?php

namespace api\controllers\ms;

use api\components\Action;
use api\components\ms\forms\RegisterUser;
use event\models\Role;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use pay\models\Product;

class CreateUserAction extends Action
{
    /**
     * @ApiAction(
     *     controller="ms",
     *     title="Создание пользователя",
     *     description="Создает нового пользователя",
     *     request=@Request(
     *          method="GET",
     *          url="/ms/createuser",
     *          params={
     *              @Param(title="RunetId", mandatory="Y", description="RunetId пользователя"),
     *              @Param(title="AuthHash", mandatory="Y", description="Проверяемый хеш")
     *          },
     *          response=@Response(body="{'Result':true}")
     *     )
     * )
     */
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
            } catch (\Exception $e) {
            }

            $this->setResult([
                'PayUrl' => 'http://msdevcon16.runet-id.com/fastauth?id='.$user->RunetId.'&hash='.$user->getHash()
            ]);
        }
    }

}
