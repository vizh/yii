<?php

namespace api\controllers\competence;

use api\components\Action;
use api\components\Exception;
use competence\models\Test;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;

class TestsAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Competence",
     *     title="Тесты",
     *     description="Доступные для мероприятия тесты.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}' '{{API_URL}}/competence/tests'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/competence/tests",
     *          response=@Response(body="['{$TEST}']")
     *      )
     * )
     */
    public function run()
    {
        $tests = Test::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll();
        
        $builtTests = [];

        foreach ($tests as $test) {
            $builtTests[] = $this->getDataBuilder()->buildCompetenceTest($test);
        }

        $this->setResult($builtTests);
    }
} 
