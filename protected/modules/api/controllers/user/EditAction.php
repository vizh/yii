<?php
namespace api\controllers\user;

use api\components\Exception;
use api\models\Account;
use api\models\ExternalUser;
use api\models\forms\user\Edit;
use event\models\UserData;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\ApiAction;
use user\models\User;
use Yii;

class EditAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="User",
     *     title="Создание",
     *     description="Редактирует пользователя.",
     *     request=@Request(
     *          method="POST",
     *          url="/user/edit",
     *          body="",
     *          params={
     *              @Param(title="Email", type="Строка", defaultValue="", description="Email."),
     *              @Param(title="LastName", type="Строка", defaultValue="", description="Фамилия."),
     *              @Param(title="FirstName", type="Строка", defaultValue="", description="Имя."),
     *              @Param(title="FatherName", type="Строка", defaultValue="", description="Отчество."),
     *              @Param(title="Attributes", type="Массив", defaultValue="", description="Расширенные атрибуты пользователя."),
     *              @Param(title="ExternalId", type="Строка", defaultValue="", description="Внешний идентификатор пользователя для привязки его профиля к сторонним сервисам.")
     *          }
     *     )
     * )
     */
    public function run()
    {
        $user = $this->getRequestedUser();
        $user->setLocale(Yii::app()->language);

        if ($this->hasEditPermission($user) === false) {
            throw new Exception(230, [$user->RunetId]);
        }

        $form = new Edit($user);
        $form->fillFromPost();
        $form->updateActiveRecord();

        $user->refresh();

        if ($this->hasRequestParam('Attributes')) {
            UserData::set($this->getEvent(), $user, $this->getRequestParam('Attributes'));
        }

        if ($this->hasRequestParam('ExternalId')) {
            $extuser = ExternalUser::model()
                ->byAccountId($this->getAccount()->Id)
                ->byUserId($user->Id)
                ->find();

            if ($extuser === null) {
                $extuser = ExternalUser::create($user, $this->getAccount());
            }

            $extuser->ExternalId = $this->getRequestParam('ExternalId');
            $extuser->save();
        }

        // Возвращаем обновлённые данные пользователя
        $userData = $this
            ->getDataBuilder()
            ->createUser($user);

        $this->setResult($userData);
    }

    /**
     * @param User $user
     * @return bool
     */
    private function hasEditPermission(User $user)
    {
        switch ($this->getAccount()->Role) {
            // Для собственных мероприятий позволяем редактировать любого посетителя
            case Account::ROLE_OWN:
                return true;
            // Для партнёрских мероприятий позволяем редактирование только зарегистрированных на мероприятие посетителей
            case Account::ROLE_PARTNER:
            case Account::ROLE_PARTNER_WOC:
                return $this->getEvent()->hasParticipant($user);
            default:
                return false;
        }

//        $permission = Permission::model()
//            ->byUserId($user->Id)
//            ->byAccountId($this->getAccount()->Id)
//            ->find();
//
//        $participant = Participant::model()
//            ->byEventId($this->getAccount()->EventId)
//            ->byUserId($user->Id)
//            ->find();
//
//        return $permission !== null && $participant !== null;
    }
}