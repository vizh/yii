<?php
namespace partner\controllers\coupon;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Поиск промо-кодов');
    $this->getController()->initActiveBottomMenu('index');

//    $criteria = new \CDbCriteria();
//    $criteria->with = array(
//      'Activations' => array('together' => true),
//      'Activations.User',
//      'Product',
//    );

    $form = new \partner\models\forms\coupon\Search();
    $form->attributes = \Yii::app()->getRequest()->getParam(get_class($form));
    $criteria = $form->getCriteria();

    $count = \pay\models\Coupon::model()->byEventId($this->getEvent()->Id)->count($criteria);

    $paginator = new \application\components\utility\Paginator($count);
    $paginator->perPage = \Yii::app()->params['PartnerCouponPerPage'];
    $criteria->mergeWith($paginator->getCriteria());

    $coupons = \pay\models\Coupon::model()->byEventId($this->getEvent()->Id)->findAll($criteria);

    $this->getController()->render('index',
      array(
        'coupons' => $coupons,
        'paginator' => $paginator,
        'form' => $form,
        'products' => $this->getProductValues()
      )
    );
  }

  private function getProductValues()
  {
    $products = \pay\models\Product::model()->byEventId($this->getEvent()->Id)
        ->findAll('"t"."ManagerName" != :ManagerName', array('ManagerName' => 'RoomProductManager'));
    $result = array();
    $result[''] = '';
    foreach ($products as $product)
    {
      $result[$product->Id] = $product->Title;
    }
    return $result;
  }

}