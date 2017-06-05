<?php
namespace partner\controllers\user\import;

use partner\components\Action;
use partner\models\forms\user\ImportPrepare;
use partner\models\Import;

\Yii::import('ext.PHPExcel.PHPExcel', true);

/**
 * Class MapAction Makes the map for the user attributes
 */
class MapAction extends Action
{
    /**
     * The run method
     * @param int $id Identifier of the import
     * @throws \CHttpException
     * @throws \PHPExcel_Exception
     */
    public function run($id)
    {
        ini_set('max_execution_time', 3600);

        $import = Import::model()->findByPk($id);
        if (!$import || $import->EventId != $this->getEvent()->Id) {
            throw new \CHttpException(404);
        }

        $request = \Yii::app()->getRequest();

        $form = new ImportPrepare($import, $this->getEvent());
        $form->attributes = $request->getParam(get_class($form));

        if ($request->isPostRequest && $form->updateImportActiveRecord($import)) {
            $this->getController()->redirect(
                \Yii::app()->createUrl('/partner/user/importroles', ['id' => $import->Id])
            );
        }

        $this->getController()->render('import/map', [
            'form' => $form,
            'worksheet' => $import->getWorksheet()
        ]);
    }
}
