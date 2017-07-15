<?php

namespace api\controllers\connect;

use api\components\Action;
use connect\models\forms\Meeting;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class InviteAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Отправляет приглашение",
     *     description="Отправляет приглашение пользователю на встречу.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X POST -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/connect/invite?PlaceId=1&CreatorId=1&UserId=1&Date=12-12-2017&Type=1&Purpose=1&Subject=1&File='")
     *     },
     *     request=@Request(
     *          method="POST",
     *          url="/connect/invite",
     *          params={
     *              @Param(title="PlaceId",     description="Айди места встречи.", mandatory="Y"),
     *              @Param(title="CreatorId",   description="Runetid создателя встречи.", mandatory="Y"),
     *              @Param(title="UserId",      description="Runetid пользователя, приглашенного на встречу.", mandatory="Y"),
     *              @Param(title="Date",        description="Дата встречи. Формат - http://php.net/manual/ru/datetime.createfromformat.php", mandatory="Y"),
     *              @Param(title="Type",        description="Тип встречи. 1-закрытая,2-открытая.", mandatory="Y"),
     *              @Param(title="Purpose",     description="Предложение.", mandatory="N"),
     *              @Param(title="Subject",     description="Тема встречи", mandatory="N"),
     *              @Param(title="File",        description="Прилагаемый файл", mandatory="N")
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
        $form->createActiveRecord();

        $this->setResult(['MeetingId' => $form->model->Id, 'Success' => $form->model->Id ? true : false]);
    }
}
