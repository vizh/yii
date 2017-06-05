<?php

namespace pay\controllers\admin\booking;

use pay\models\forms\admin\FoodNaturalForm;

class FoodNaturalFormAction extends \CAction
{
    public function run()
    {
        $model = new FoodNaturalForm();
        if (\Yii::app()->request->isPostRequest) {
            $model->fillFromPost();
            if ($model->validate()) {
                $model->save();
                $this->controller->redirect(['foodNatural']);
            }
        }
        echo $this->controller->render('food-natural-form', [
            'model' => $model
        ]);
    }
}