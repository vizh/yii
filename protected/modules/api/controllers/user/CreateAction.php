<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use api\models\ExternalUser;
use api\models\forms\user\Register;
use event\models\UserData;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\ApiAction;
use user\models\User;

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
     *              @Param(title="Email", type="Строка", description="Email. Обязательный."),
     *              @Param(title="LastName", type="Строка", description="Фамилия. Обязательный."),
     *              @Param(title="FirstName", type="Строка", description="Имя. Обязательный."),
     *              @Param(title="FatherName", type="Строка", description="Отчество."),
     *              @Param(title="Phone", type="Строка", description="Телефон."),
     *              @Param(title="Photo", type="Строка", description="Ссылка на фотографию."),
     *              @Param(title="Company", type="Строка", description="Компания."),
     *              @Param(title="Position", type="Строка", description="Должность."),
     *              @Param(title="ExternalId", type="Строка", description="Внешний идентификатор пользователя для привязки его профиля к сторонним сервисам."),
     *              @Param(title="Attributes", type="Массив", description="Расширенные атрибуты пользователя."),
     *              @Param(title="Visible", type="Логическое", defaultValue="true", description="Видимость пользователя."),
     *              @Param(title="DoUnsubscribe", type="Логическое", defaultValue="false", description="Сразу же отписать пользователя от рассылок.")
     *          }
     *     )
     * )
     */
    public function run()
    {
        $form = new Register($this->getAccount());
        $form->fillFromPost();

        $user = $form->createActiveRecord();

        if ($this->hasRequestParam('Attributes')) {
            UserData::set($this->getEvent(), $user, $this->getRequestParam('Attributes'));
        }

        if ($this->hasRequestParam('ExternalId')) {
            ExternalUser::create($user, $this->getAccount(), $this->getRequestParam('ExternalId'))
                ->save();
        }

        if ($this->hasRequestParam('Photo')) {
            $user->getPhoto()->save($this->getRequestParam('Photo'));
        }

        if ($this->getRequestParamBool('DoUnsubscribe')) {
            $userSettings = $user->Settings;
            $userSettings->UnsubscribeAll = true;
            if (false === $userSettings->save()) {
                throw new Exception($userSettings);
            }
        }

        $userData = $this
            ->getDataBuilder()
            ->createUser($user);

        $this->setResult($userData);
    }
}
