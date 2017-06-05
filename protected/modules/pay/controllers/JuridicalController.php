<?php

class JuridicalController extends \pay\components\Controller
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
            'create' => 'pay\controllers\juridical\CreateAction',
            'delete' => 'pay\controllers\juridical\DeleteAction',
        ];
    }
}
