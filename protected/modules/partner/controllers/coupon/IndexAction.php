<?php
namespace partner\controllers\coupon;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Поиск промо-кодов');
    $this->getController()->initActiveBottomMenu('index');

    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Activations' => array('together' => true),
      'Activations.User',
      'Product',
    );

    $count = \pay\models\Coupon::model()->byEventId($this->getEvent()->Id)->count($criteria);

    $paginator = new \application\components\utility\Paginator($count);
    $paginator->perPage = \Yii::app()->params['PartnerCouponPerPage'];
    $criteria->mergeWith($paginator->getCriteria());

    $coupons = \pay\models\Coupon::model()->byEventId($this->getEvent()->Id)->findAll($criteria);


    $this->getController()->render('index',
      array(
        'coupons' => $coupons,
        'paginator' => $paginator
      )
    );
  }

  private function filter()
  {
//    $filter = $request->getParam('filter', array());
//    if ( !empty ($filter))
//    {
//      foreach ($filter as $field => $value)
//      {
//        if ( $value !== '')
//        {
//          switch ($field)
//          {
//            case 'Discount':
//              if ( (int) $value['From'] > 0)
//              {
//                $criteria->addCondition('t.Discount >= :DiscountFrom');
//                $criteria->params[':DiscountFrom'] = $value['From'] / 100;
//              }
//
//              if ( (int) $value['To'] > 0)
//              {
//                $criteria->addCondition('t.Discount <= :DiscountTo');
//                $criteria->params[':DiscountTo'] = $value['To'] / 100;
//              }
//              break;
//
//            case 'Code':
//              $criteria->addCondition('t.Code = :Code');
//              $criteria->params[':Code'] = $value;
//              break;
//
//            case 'Recipient':
//              $criteria->addCondition(
//                't.Recipient IS '. ((int) $value == 1 ? 'NOT' : '') .' NULL'
//              );
//              break;
//
//            case 'Activated':
//              $criteria->addCondition(
//                'CouponActivatedList.CouponActivatedId IS '. ((int) $value == 1 ? 'NOT' : '') .' NULL'
//              );
//              break;
//          }
//        }
//        else
//        {
//          unset ($filter[$field]);
//        }
//      }
//    }
  }
}