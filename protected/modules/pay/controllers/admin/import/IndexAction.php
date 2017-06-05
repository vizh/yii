<?php
namespace pay\controllers\admin\import;

use pay\models\Import;

class IndexAction extends \pay\components\Action
{
    public function run()
    {
        ini_set('max_execution_time', 3600);

        if (\Yii::app()->getRequest()->isPostRequest) {
            $file = \CUploadedFile::getInstanceByName('import_file');
            if ($file != null) {
                $import = new Import();
                $import->CreationTime = date('Y-m-d H:i:s');
                $import->save();
                $import->refresh();
                $file->saveAs($import->getFileName());
                $import->importOrders();
                $this->getController()->redirect(\Yii::app()->createUrl('/pay/admin/import/result', ['id' => $import->Id]));
            }
        }

        $imports = Import::model()->findAll();
        $this->getController()->render('index', [
            'imports' => $imports
        ]);
    }
}
