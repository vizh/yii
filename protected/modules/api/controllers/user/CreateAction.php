<?php
namespace api\controllers\user;

use api\components\Action;
use api\models\forms\user\Register;

class CreateAction extends Action
{
    public function run()
    {
        $form = new Register($this->getAccount());
        $form->fillFromPost();
        $user = $form->createActiveRecord();

        $builder = $this->getAccount()->getDataBuilder();

        $builder->createUser($user);
        if ($this->getAccount()->Role != 'mobile') {
            $builder->buildUserContacts($user);
        }
        $builder->buildUserEmployment($user);
        $this->getController()->setResult($builder->buildUserEvent($user));
    }
}
