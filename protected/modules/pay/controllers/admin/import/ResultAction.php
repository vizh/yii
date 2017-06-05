<?php
namespace pay\controllers\admin\import;

use pay\models\Import;

class ResultAction extends \pay\components\Action
{
    public function run($id)
    {
        ini_set('max_execution_time', 3600);
        $import = Import::model()->findByPk($id);
        $this->controller->render('result', ['import' => $import]);
    }
}
