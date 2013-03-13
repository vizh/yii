<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alaris
 * Date: 3/13/13
 * Time: 3:17 PM
 * To change this template use File | Settings | File Templates.
 */ 
class TestController extends CController
{
  public function actionIndex()
  {
    $coupons = \pay\models\Coupon::model()->findAll();
    foreach ($coupons as $coupon)
    {
      echo '<pre>';
      print_r($coupon);
      echo '</pre>';
    }
  }
}
