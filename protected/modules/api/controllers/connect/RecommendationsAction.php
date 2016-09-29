<?php
namespace api\controllers\connect;

use api\components\builders\Builder;
use user\models\User;

class RecommendationsAction extends \api\components\Action
{
    public function run()
    {
        $user = $this->getRequestedUser();
        // ... тут код для получения рекомендаций для текущего пользователя ...
        $users = User::model()->findAllByPk([572793, 563843, 561735, 456]);
        // ... конец кода для получения рекомендаций

        $result = [];
        foreach ($users as $user) {
            $result[] = $this->getDataBuilder()->createUser($user, [
                Builder::USER_EMPLOYMENT,
                Builder::USER_CONTACTS,
                Builder::USER_DATA
            ]);
        }

        $this->setResult(['Success' => true, 'Users' => $result]);
    }
}