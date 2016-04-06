<?php
namespace partner\controllers\user\import;

use partner\models\Import;

class IndexAction extends \partner\components\Action
{
    public function run()
    {
        ini_set('max_execution_time', 3600);

        if (\Yii::app()->getRequest()->isPostRequest) {
            $file = \CUploadedFile::getInstanceByName('import_file');
            if ($file != null) {
                $import = new Import();
                $import->EventId = $this->getEvent()->Id;
                $import->save();
                $file->saveAs($import->getFileName());
                $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/importmap', ['id' => $import->Id]));
            }
        }

        $imports = Import::model()->findAll('"t"."EventId" = :EventId', [
            'EventId' => $this->getEvent()->Id
        ]);
        $this->getController()->render('import/index', [
            'imports' => $imports
        ]);
    }
}
