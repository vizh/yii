<?php

namespace partner\controllers\paperless\material;

use application\components\Exception;
use application\models\paperless\Material as MaterialModel;
use partner\components\Action;
use partner\models\forms\paperless\Material;
use Yii;

class EditAction extends Action
{
    public function run($id = null)
    {
        $material = $id === null
            ? new MaterialModel()
            : MaterialModel::model()->findByPk($id);

        if ($material === null) {
            throw new Exception(404);
        }

        $form = new Material($this->getEvent(), $material);

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            $model = $material->isNewRecord
                ? $form->createActiveRecord()
                : $form->updateActiveRecord();

            if ($model !== null) {
                $this->getController()->redirect(['materialIndex']);
            }
        }

        $this->getController()->render('material/edit', [
            'form' => $form,
            'material' => $material
        ]);
    }
}