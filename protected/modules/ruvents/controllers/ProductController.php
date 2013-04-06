<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 8/29/12
 * Time: 6:23 PM
 * To change this template use File | Settings | File Templates.
 */
class ProductController extends \ruvents\components\Controller
{
  public function actions()
  {
    return array(
      'paiditems' => 'ruvents\controllers\product\PaiditemsAction',
      'paiditemslist' => 'ruvents\controllers\product\PaiditemsListAction',
      'changepaid' => 'ruvents\controllers\product\ChangepaidAction'
    );
  }



}