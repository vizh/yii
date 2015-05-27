<?php
use \partner\components\Controller;

class UserController extends Controller
{
    const UsersOnPage = 20;

    public function actions()
    {
        return [
            'index' => '\partner\controllers\user\IndexAction',
            'edit' => '\partner\controllers\user\EditAction',
            'translate' => '\partner\controllers\user\TranslateAction',
            'ajaxget' => '\partner\controllers\user\AjaxGetAction',
            'register' => '\partner\controllers\user\RegisterAction',
            'statistics' => '\partner\controllers\user\StatisticsAction',
            'export' => '\partner\controllers\user\ExportAction',
            'invite' => '\partner\controllers\user\InviteAction',
            'import' => '\partner\controllers\user\import\IndexAction',
            'importmap' => '\partner\controllers\user\import\MapAction',
            'importroles' => '\partner\controllers\user\import\RolesAction',
            'importproducts' => '\partner\controllers\user\import\ProductsAction',
            'importprocess' => '\partner\controllers\user\import\ProcessAction',
            'importerrors' => '\partner\controllers\user\import\ErrorsAction',
            'competence' => '\partner\controllers\user\CompetenceAction'
        ];
    }
}
