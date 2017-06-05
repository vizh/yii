<?php
namespace api\controllers\event;

use api\components\Action;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use PharData;
use user\models\Photo;
use user\models\User;
use Yii;

class UsersPhotosAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Фотографии участников",
     *     description="Возвращает Фотографии участников одним архивом.",
     *     request=@Request(
     *          method="GET",
     *          url="/event/usersphotos",
     *          params={},
     *          response=@Response(body="")
     *     )
     * )
     */
    public function run()
    {
        ini_set('max_execution_time', '1800');

        $request = Yii::app()->getRequest();

        $ids = Yii::app()->getDb()->createCommand('
            SELECT
              "User"."RunetId"
            FROM "EventParticipant"
              RIGHT JOIN "User" ON "User"."Id" = "EventParticipant"."UserId"
            WHERE "EventId" = :EventId
              AND "User"."UpdateTime" >= :UpdateTime
        ')->queryColumn([
            'EventId' => $this->getEvent()->Id,
            'UpdateTime' => $request->getParam('Start', '1111-11-11 11:11:11')
        ]);

        /** @noinspection NonSecureUniqidUsageInspection */
        $archive = Yii::getPathOfAlias('application.runtime').'/'.uniqid().'.tar';
        $tar = new PharData($archive);
        $tar->startBuffering();

        if (empty($ids)) {
            $tar->addFile(User::model()
                ->byRunetId(424)
                ->find()
                ->getPhoto()
                ->getOriginal(true)
            );
        } else {
            foreach ($ids as $runetid) {
                $photo = new Photo($runetid);
                if ($photo->hasImage()) {
                    $photo = $photo->getOriginal(true);
                    $tar->addFile($photo, basename($photo));
                }
            }
        }

        $tar->stopBuffering();

        if (is_file($archive)) {
            unset($tar);
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($archive).'"');
            header('Content-Length: '.filesize($archive));
            readfile($archive);
            unlink($archive);
        }

        Yii::log(sprintf('Сгенерирован архив с %d изображениями c %s',
            count($ids),
            $request->getParam('Start', '1111-11-11 11:11:11')
        ));
    }
}