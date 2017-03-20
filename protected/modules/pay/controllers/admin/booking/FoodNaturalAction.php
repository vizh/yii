<?php

namespace pay\controllers\admin\booking;

use pay\models\search\admin\booking\FoodNaturalSearch;

class FoodNaturalAction extends \CAction
{
    public function run()
    {
        $model = new FoodNaturalSearch();
        echo $this->controller->render('food-natural', [
            'model' => $model
        ]);
    }
}