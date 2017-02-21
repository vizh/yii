<?php
namespace api\controllers\connect;

use connect\models\forms\Meeting;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Sample;

class CreateAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Создание встречи",
     *     description="Создает новую встречу",
     *     samples={
     *          @Sample(lang="shell", code="curl -X POST -H 'Content-Type: application/x-www-form-urlencoded' -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}' -d 'PlaceId=1&CreatorId=678047&UserId=678047&Date=15-Feb-2017&Type=1&Purpose=Предложение&Subject=Тема встречи&File='
    '{{API_URL}}/connect/create'")
     *     },
     *     request=@Request(
     *          method="POST",
     *          url="/connect/create",
     *          params={
     *              @Param(title="PlaceId",     mandatory="Y",  description="Айди места встречи." ),
     *              @Param(title="CreatorId",   mandatory="Y",  description="Runetid создателя встречи." ),
     *              @Param(title="UserId",      mandatory="Y",  description="Runetid пользователя, приглашенного на встречу."),
     *              @Param(title="Date",        mandatory="Y",  description="Дата встречи. Формат - http://php.net/manual/ru/datetime.createfromformat.php"),
     *              @Param(title="Type",        mandatory="Y",  description="Тип встречи. 1-закрытая,2-открытая."),
     *              @Param(title="Purpose",     mandatory="N",  description="Предложение."),
     *              @Param(title="Subject",     mandatory="N",  description="Тема встречи"),
     *              @Param(title="File",        mandatory="N",  description="Прилагаемый файл"),
     *          },
     *          response=@Response(body="{
                    'Success': true,
                    'Meeting': '{$MEETING}',
                    'Errors': []
                }")
     *      )
     * )
     */
    public function run()
    {
        $form = new Meeting();
        $form->fillFromPost();
        $success = $form->createActiveRecord();

        if ($success){
            $this->setResult([
                'Success' => true,
                'Meeting' => $this->getAccount()->getDataBuilder()->createMeeting($form->model),
                'Errors' => $form->errors
            ]);
        }
        else{
            $this->setResult([
                'Success' => false,
                'Errors' => $form->errors
            ]);
        }

    }
}