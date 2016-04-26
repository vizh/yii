<?php

namespace api\controllers\competence;

use api\components\Action;
use api\components\Exception;
use competence\models\Test;

/**
 * Class TestsAction
 */
class TestsAction extends Action
{
    /**
     * @throws Exception
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
