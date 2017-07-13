<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\ApiAction;
use Yii;

class EditPasswordAction extends Action
{
    /**
     * @ApiAction(
     *     controller="User",
     *     title="Редактирование пароля",
     *     description="Позволяет сменить пароль указанного пользователя.",
     *     request=@Request(
     *          method="POST",
     *          url="/user/edit/password",
     *          params={
     *              @Param(title="CurrentPassword", type="Cтрока", mandatory="Y", description="Текущий пароль"),
     *              @Param(title="NewPassword", type="Cтрока", mandatory="Y", description="Новый пароль")}))
     */
    public function run()
    {
        // Данный метод не будет работать быстро во избежание перебора пароля
        sleep(Yii::app()->getParams()->SecureLoginCheckDelay);

        $user = $this->getRequestedUser();

        // Меняем пароль, в случае, если текущий задан верно
        $isSuccess = $user->setPassword(
            $this->getRequestParam('CurrentPassword'),
            $this->getRequestParam('NewPassword')
        );

        // Сообщим об ошибке, если пароль не изменён, что означает неверность CurrentPassword
        if ($isSuccess === false) {
            throw new Exception(201);
        }

        if (false === $user->save()) {
            throw new Exception($user);
        }

        $this->setSuccessResult();
    }
}