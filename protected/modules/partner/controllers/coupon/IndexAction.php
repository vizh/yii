<?php
namespace partner\controllers\coupon;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Поиск промо-кодов');
    $this->getController()->initBottomMenu('index');

    $cs = \Yii::app()->clientScript;
    $cs->registerScriptFile(\Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/js/partner/coupon.index.js'), \CClientScript::POS_HEAD);

    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params = array(
      ':EventId' => \Yii::app()->partner->getAccount()->EventId
    );
    $criteria->with = array(
      'CouponActivatedList' => array('together' => true),
      'Product'
    );

    $request = \Yii::app()->request;
    $page = (int) $request->getParam('page', 0);
    if ($page <= 0)
    {
      $page = 1;
    }

    $criteria->limit  = \CouponController::CouponOnPage;
    $criteria->offset = \CouponController::CouponOnPage * ($page-1);

    $filter = $request->getParam('filter', array());
    if ( !empty ($filter))
    {
      foreach ($filter as $field => $value)
      {
        if ( $value !== '')
        {
          switch ($field)
          {
            case 'Discount':
              if ( (int) $value['From'] > 0)
              {
                $criteria->addCondition('t.Discount >= :DiscountFrom');
                $criteria->params[':DiscountFrom'] = $value['From'] / 100;
              }

              if ( (int) $value['To'] > 0)
              {
                $criteria->addCondition('t.Discount <= :DiscountTo');
                $criteria->params[':DiscountTo'] = $value['To'] / 100;
              }
              break;

            case 'Code':
              $criteria->addCondition('t.Code = :Code');
              $criteria->params[':Code'] = $value;
              break;

            case 'Recipient':
              $criteria->addCondition(
                't.Recipient IS '. ((int) $value == 1 ? 'NOT' : '') .' NULL'
              );
              break;

            case 'Activated':
              $criteria->addCondition(
                'CouponActivatedList.CouponActivatedId IS '. ((int) $value == 1 ? 'NOT' : '') .' NULL'
              );
              break;
          }
        }
        else
        {
          unset ($filter[$field]);
        }
      }
    }

    $coupons = \pay\models\Coupon::model()->findAll($criteria);
    $count = \pay\models\Coupon::model()->count($criteria);

    $this->getController()->render('index',
      array(
        'filter' => $filter,
        'coupons' => $coupons,
        'count' => $count,
        'page' => $page
      )
    );
  }
}