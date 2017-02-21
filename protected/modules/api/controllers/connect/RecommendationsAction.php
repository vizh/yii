<?php
namespace api\controllers\connect;

use api\components\builders\Builder;
use user\models\User;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Sample;

class RecommendationsAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Рекомендации",
     *     description="Рекомендации.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/connect/recommendations?RunetId=678047'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/connect/recommendations",
     *          body="",
     *          params={
     *              @Param(title="RunetId", description="RunetId пользователя для которого вернутся рекоммендации.", mandatory="Y"),
     *          },
     *          response=@Response(body="{'Success': true, 'Users': ['{$USER}']}")
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