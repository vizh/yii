<?php

namespace api\controllers\competence;

use api\components\Action;
use api\components\Exception;
use competence\models\Test;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;

class TestsAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Competence",
     *     title="Тесты",
     *     description="Доступные для мероприятия тесты.",
     *     request=@Request(
     *          method="GET",
     *          url="/competence/tests",
     *          body="",
     *          response=@Response(body="[{'Id':1,'Title':'Исследование профессионального <br>интернет-сообщества','Questions':{'C2':{'Title':'Укажите Ваш пол','Values':{'1':'Мужской','2':'Женский'}},'Q10':{'Title':'С какого курса вы работаете на постоянной основе?','Values':{'1':'не работаю и никогда не работал на постоянной основе','2':'работал еще до поступления в вуз','3':'с первого курса','4':'со второго курса','5':'с третьего курса','6':'с четвертого курса','7':'с пятого курса','8':'с шестого курса','9':'со времен учебы в аспирантуре или получения второго высшего образования','10':'начал работать на постоянной основе после завершения обучения'}}}}]")
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
