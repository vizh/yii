<?php
namespace api\controllers\user;

use api\components\Action;
use api\models\forms\user\Register;
use event\models\UserData;
use user\models\User;

/**
 * Class CreateAction Creates a new user
 */
class CreateAction extends Action
{
    /**
     * @inheritdoc
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
