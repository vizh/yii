<?php
namespace api\controllers\user;

use api\components\Action;
use api\models\forms\user\Register;
use event\models\UserData;
use user\models\User;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;

/**
 * Class CreateAction Creates a new user
 */
class CreateAction extends Action
{
    /**
     * @ApiAction(
     *     controller="User",
     *     title="Создание",
     *     description="Создает нового пользователя.",
     *     request=@Request(
     *          method="POST",
     *          url="/user/create",
     *          body="",
     *          params={
     *              @Param(title="Email", type="Строка", defaultValue="", description="Email. Обязательно."),
     *              @Param(title="LastName", type="Строка", defaultValue="", description="Фамилия. Обязательно."),
     *              @Param(title="FirstName", type="Строка", defaultValue="", description="Имя. Обязательно."),
     *              @Param(title="FatherName", type="Строка", defaultValue="", description="Отчество."),
     *              @Param(title="Phone", type="Строка", defaultValue="", description="Телефон."),
     *              @Param(title="Company", type="Строка", defaultValue="", description="Компания."),
     *              @Param(title="Position", type="Строка", defaultValue="", description="Должность.")
     *          }
     *     )
     * )
     */
    public function run()
    {
        $form = new Register($this->getAccount());
        $form->fillFromPost();

        /** @var User $user */
        $user = $form->createActiveRecord();

        if ($this->hasRequestParam('Attributes')) {
            UserData::set($this->getEvent(), $user, $this->getRequestParam('Attributes'));
        }

        $userData = $this
            ->getDataBuilder()
            ->createUser($user);

        $this->setResult($userData);
    }
}
