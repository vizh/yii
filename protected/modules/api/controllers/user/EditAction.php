<?php
namespace api\controllers\user;

use api\components\Exception;
use api\models\Account;
use api\models\forms\user\Edit;
use event\models\Participant;
use event\models\UserData;
use oauth\models\Permission;
use user\models\User;
use Yii;

class EditAction extends \api\components\Action
{
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
        return true;
        // Для собственных мероприятий позволяем редактировать любого посетителя
        if ($this->getAccount()->Role === Account::ROLE_OWN) {
            return true;
        }

        $permission = Permission::model()
            ->byUserId($user->Id)
            ->byAccountId($this->getAccount()->Id)
            ->find();

        $participant = Participant::model()
            ->byEventId($this->getAccount()->EventId)
            ->byUserId($user->Id)
            ->find();

        return $permission !== null && $participant !== null;
    }
}