<?php
namespace api\controllers\connect;

use api\components\builders\Builder;
use user\models\User;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Param;

class RecommendationsAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Рекомендации",
     *     description="Рекомендации.",
     *     request=@Request(
     *          method="GET",
     *          url="/connect/recommendations",
     *          body="",
     *          params={
     *              @Param(title="RunetId", description="RunetId пользователя для которого вернутся рекоммендации.", mandatory="Y"),
     *          },
     *          response=@Response(body="{'Success': true, 'Users': ['Объект USER']}")
     *      )
     * )
     */
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