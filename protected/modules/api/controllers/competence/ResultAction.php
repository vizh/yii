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
     *          response=@Response(body="{'competence\\models\\tests\\mailru2013\\First':{'Value':'2'},'competence\\models\\tests\\mailru2013\\S2':{'Value':'5'},'competence\\models\\tests\\mailru2013\\E1_1':{'Value':['1','3','7']},'competence\\models\\tests\\mailru2013\\E2':{'Value':{'1':'4','3':'6','7':'1'}},'competence\\models\\tests\\mailru2013\\A1':{'Value':{'49':'1'}},'competence\\models\\tests\\mailru2013\\A4':{'Value':['41','43','48']},'competence\\models\\tests\\mailru2013\\A5':{'Value':{'41':['7'],'48':['7'],'43':['7']}},'competence\\models\\tests\\mailru2013\\A6':{'Value':['1','8']},'competence\\models\\tests\\mailru2013\\A6_1':{'Value':{'1':['7'],'8':['1','4','7']}},'competence\\models\\tests\\mailru2013\\A8':{'Value':['2','8','11','4','9']},'competence\\models\\tests\\mailru2013\\A9':{'Value':['8','9']},'competence\\models\\tests\\mailru2013\\A10':{'Value':{'4':['89'],'3':['84'],'2':['85'],'7':['90'],'5':['85'],'8':['89'],'1':['84'],'9':['85'],'6':['85']}},'competence\\models\\tests\\mailru2013\\A10_1':{'Value':{'12':['85'],'17':['90'],'16':['89'],'14':['89'],'15':['85'],'13':['85'],'18':['89'],'11':['84'],'10':['90']}},'competence\\models\\tests\\mailru2013\\S5':{'Value':'2'},'competence\\models\\tests\\mailru2013\\S6':{'Value':'5'},'competence\\models\\tests\\mailru2013\\S7':{'Value':'3'},'competence\\models\\tests\\mailru2013\\S3_1':{'Value':'8'},'competence\\models\\tests\\mailru2013\\C1':{'Value':'1983'},'competence\\models\\tests\\mailru2013\\C2':{'Value':'1'},'competence\\models\\tests\\mailru2013\\C3':{'Value':'19'},'competence\\models\\tests\\mailru2013\\C4':{'Value':'3'},'competence\\models\\tests\\mailru2013\\C5':{'Value':'5'},'competence\\models\\tests\\mailru2013\\C6':{'Value':['7','14','21']}}")
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
