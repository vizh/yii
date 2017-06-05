<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 02.09.2015
 * Time: 14:35
 */

namespace partner\controllers\user\export;

use partner\components\Action;
use partner\models\Export;

class DownloadAction extends Action
{
    /**
     * @param int $id ID экспорта
     * @throws \CHttpException
     */
    public function run($id)
    {
        $export = Export::model()->byEventId($this->getEvent()->Id)->bySuccess(true)->findByPk($id);
        if ($export == null) {
            throw new \CHttpException(404);
        }
        $title = \Yii::t('app', 'Участники').' '.$export->Event->Title.'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$title.'"');
        echo file_get_contents($export->FilePath);
    }
}