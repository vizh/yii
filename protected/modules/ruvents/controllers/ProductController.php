<?php

class ProductController extends \ruvents\components\Controller
{
    public function actions()
    {
        return array(
            'paiditems' => 'ruvents\controllers\product\PaiditemsAction',
            'paiditemslist' => 'ruvents\controllers\product\PaiditemsListAction',
            'changepaid' => 'ruvents\controllers\product\ChangepaidAction',
            'list' => 'ruvents\controllers\product\ListAction',
        );
    }

}