<?php
namespace partner\controllers\coupon;

use application\modules\partner\models\search\Coupons;

class IndexAction extends \partner\components\Action
{
    public function run()
    {
        $search = new Coupons($this->getEvent());
        $this->getController()->render('index', [
            'search' => $search
        ]);
        exit;




        $hasTicket = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->byPublic(true)->byManagerName('Ticket')->exists();

        $form = new \partner\models\forms\coupon\Search();
        $form->attributes = \Yii::app()->getRequest()->getParam(get_class($form));
        $criteria = new \CDbCriteria();
        $criteria->with = ['Owner'];
        $criteria->mergeWith($form->getCriteria());
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
                'products' => $this->getProductValues(),
                'hasTicket' => $hasTicket,
                'event' => $this->getEvent()
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