<?php

use partner\components\Controller;

class OrderitemController extends Controller
{
    public function actions()
    {
        return [
            'index' => '\partner\controllers\orderitem\IndexAction',
            'create' => '\partner\controllers\orderitem\CreateAction',
            'redirect' => '\partner\controllers\orderitem\RedirectAction',
            'refund' => '\partner\controllers\orderitem\RefundAction'
        ];
    }
}
