<?php
namespace partner\controllers\paperlessmaterial;

use partner\components\Action;
use partner\models\forms\paperless\Material;
use paperless\models\Material as MaterialModel;

class EditAction extends Action
{
    public function run($id = null)
    {
        if ($id){
            $material = MaterialModel::model()->findByPk($id);
            if (!$material){
                throw new \CHttpException(404);
            }
        }
        else {
            $material = new MaterialModel();
        }

        $form = new Material($this->getEvent(), $material);

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            if ($material->isNewRecord){
                $model = $form->createActiveRecord();
            }
            else{
                $model = $form->updateActiveRecord();
            }
            if ($model !== null) {
                $this->getController()->redirect(['index']);
            }
        }

        $this->getController()->render('edit', ['form' => $form, 'material' => $material]);
    }
}