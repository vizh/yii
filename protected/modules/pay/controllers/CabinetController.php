<?php

use \pay\components\Controller;

class CabinetController extends Controller
{
    /**
     * @return array Фильтры
     */
    public function filters()
    {
        return array_merge(parent::filters(), [
            'postOnly + deleteitem'
        ]);
    }

    public function actions()
    {
        return [
            'register' => 'pay\controllers\cabinet\RegisterAction',
            'index' => 'pay\controllers\cabinet\IndexAction',
            'deleteitem' => 'pay\controllers\cabinet\DeleteItemAction',
            'pay' => 'pay\controllers\cabinet\PayAction',
            'return' => 'pay\controllers\cabinet\ReturnAction',
            'offer' => 'pay\controllers\cabinet\OfferAction',
            'auth' => 'pay\controllers\cabinet\AuthAction'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setHeaders()
    {
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Origin: http://pay.' . RUNETID_HOST);
        parent::setHeaders();
    }


}
