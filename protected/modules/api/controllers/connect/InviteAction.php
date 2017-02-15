<?php
namespace api\controllers\connect;

use connect\models\forms\Meeting;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Param;

class InviteAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Отправляет приглашение",
     *     description="Отправляет приглашение пользователю на встречу.",
     *     request=@Request(
     *          method="POST",
     *          url="/connect/invite",
     *          body="",
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
                    'Meeting': 'Объект MEETING',
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