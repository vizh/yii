<?php

namespace api\controllers\competence;

use api\components\Action;
use api\components\Exception;
use competence\models\Result;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use user\models\User;

class ResultAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Competence",
     *     title="Результаты теста",
     *     description="Результаты теста с заданным TestId для пользователя с заданным RunetId.",
     *     params={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/competence/result?RunetId=656438&TestId=55'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/competence/result",
     *          params={
     *              @Param(title="RunetId", description="", mandatory="Y"),
     *              @Param(title="TestId", description="", mandatory="Y")
     *          },
     *          response=@Response(body="'{$TEST_RESULT}'")
     *      )
     * )
     */
    public function run($RunetId, $TestId)
    {
        $RunetId = (int)$RunetId;
        $TestId = (int)$TestId;

        $user = User::model()
            ->byRunetId($RunetId)
            ->find();

        if (!$user) {
            throw new Exception(202, [$RunetId]);
        }

        $result = Result::model()
            ->byUserId($user->Id)
            ->byTestId($TestId)
            ->find();

        if (!$result) {
            throw new Exception(3009, [$RunetId]);
        }

        $builtResult = $this->getDataBuilder()->buildCompetenceResult($result);

        $this->setResult($builtResult);
    }
}
