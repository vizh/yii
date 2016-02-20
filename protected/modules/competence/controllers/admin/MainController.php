<?php

class MainController extends \application\components\controllers\AdminMainController
{
    public function actions()
    {
        return [
            'index' => 'competence\controllers\admin\main\IndexAction',
            'edit' => 'competence\controllers\admin\main\EditAction',
            'editQuestion' => 'competence\controllers\admin\main\EditQuestionAction',
        ];
    }
}
