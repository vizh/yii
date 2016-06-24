<?php
use \partner\components\Controller;
use partner\models\Export;

class UserController extends Controller
{
    const UsersOnPage = 20;

    public function actions()
    {
        return [
            'index' => '\partner\controllers\user\IndexAction',
            'find' => '\partner\controllers\user\FindAction',
            'edit' => '\partner\controllers\user\EditAction',
            'viewdatafile' => '\partner\controllers\user\ViewDataFileAction',
            'translate' => '\partner\controllers\user\TranslateAction',
            'ajaxget' => '\partner\controllers\user\AjaxGetAction',
            'register' => '\partner\controllers\user\RegisterAction',
            'export' => '\partner\controllers\user\export\IndexAction',
            'exportdownload' => '\partner\controllers\user\export\DownloadAction',
            'invite' => '\partner\controllers\user\InviteAction',
            'import' => '\partner\controllers\user\import\IndexAction',
            'importmap' => '\partner\controllers\user\import\MapAction',
            'importroles' => '\partner\controllers\user\import\RolesAction',
            'importproducts' => '\partner\controllers\user\import\ProductsAction',
            'importprocess' => '\partner\controllers\user\import\ProcessAction',
            'importerrors' => '\partner\controllers\user\import\ErrorsAction',
            'competence' => '\partner\controllers\user\CompetenceAction',
            'data' => '\partner\controllers\user\DataAction',
            'savecrop' => 'partner\controllers\user\SaveCropAction'
        ];
    }
}
