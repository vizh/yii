<?php

namespace api\controllers\competence;

use api\components\Action;
use api\components\Exception;
use competence\models\Result;
use user\models\User;

/**
 * Class ResultAction
 */
class ResultAction extends Action
{
    /**
     * @param int $RunetId
     * @param int $TestId
     * @throws Exception
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
