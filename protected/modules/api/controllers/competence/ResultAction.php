<?php

namespace api\controllers\competence;

use api\components\Action;
use api\components\Exception;
use competence\models\Result;
use user\models\User;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class ResultAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Competence",
     *     title="Результаты теста",
     *     description="Результаты теста с заданным TestId для пользователя с заданным RunetId.",
     *     request=@Request(
     *          method="GET",
     *          url="/competence/result",
     *          body="",
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
