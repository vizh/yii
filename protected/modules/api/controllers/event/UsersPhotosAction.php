<?php
namespace api\controllers\event;

use api\components\Action;
use CDbCriteria;
use Yii;

class UsersPhotosAction extends Action
{
    public function run()
    {
        ini_set('max_execution_time', '1800');

        $request = Yii::app()->getRequest();
        $roles = $request->getParam('RoleId');

        $command = Yii::app()->getDb()->createCommand()
            ->select('EventParticipant.UserId')->from('EventParticipant')
            ->where('"EventParticipant"."EventId" = '.$this->getEvent()->Id);

        if ($this->hasRequestParam('Start')) {
            $command->andWhere('"EventParticipant"."CreationTime" >= :Start', [':Start' => $this->getRequestedDate('Start')]);
            if ($this->hasRequestParam('End')) {
                $command->andWhere('"EventParticipant"."CreationTime" <= :End', [':End' => $this->getRequestedDate('End')]);
            }
        }

        if (!empty($roles)) {
            $command->andWhere(['in', 'EventParticipant.RoleId', $roles]);
        }

        $criteria = new CDbCriteria();
        $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';
        $criteria->addCondition('"t"."Id" IN ('.$command->getText().')');
        $criteria->params = $command->params;
        $dataProvider = new \CActiveDataProvider('user\models\User', ['criteria' => $criteria]);
        $users = new \CDataProviderIterator($dataProvider);

        /** @noinspection NonSecureUniqidUsageInspection */
        $archive = \Yii::getPathOfAlias('application.runtime').'/'.uniqid().'.tar';
        $tar = new \PharData($archive);
        foreach ($users as $user) {
            /** @var \user\models\User $user */
            $photo = $user->getPhoto()->getOriginal(true);
            if (is_file($photo)) {
                $tar->addFile($photo, basename($photo));
            }
        }
        if (is_file($archive)) {
            $tar->compress(\Phar::GZ);
            unset($tar);
            unlink($archive);
            $archive .= '.gz';
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($archive).'"');
            header('Content-Length: '.filesize($archive));
            readfile($archive);
            unlink($archive);
        }
    }
}