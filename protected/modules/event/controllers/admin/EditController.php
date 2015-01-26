<?php
class EditController extends \application\components\controllers\AdminMainController
{
    public function actions()
    {
        return [
            'index' => '\event\controllers\admin\edit\IndexAction',
            'widget' => '\event\controllers\admin\edit\WidgetAction',
            'product' => '\event\controllers\admin\edit\ProductAction',

            'parts' => '\event\controllers\admin\edit\part\IndexAction',
            'partedit' => '\event\controllers\admin\edit\part\EditAction',
            'partdelete' => '\event\controllers\admin\edit\part\DeleteAction',
        ];
    }
}
