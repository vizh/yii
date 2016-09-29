<?php
namespace api\controllers\user;

use api\components\Action;
use api\models\forms\user\Register;
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

        $userData = $this
            ->getDataBuilder()
            ->createUser($user);

        $this->setResult($userData);
    }
}
