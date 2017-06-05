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
    }

    private function getProductValues()
    {
        $products = \pay\models\Product::model()->byEventId($this->getEvent()->Id)
            ->findAll('"t"."ManagerName" != :ManagerName', ['ManagerName' => 'RoomProductManager']);
        $result = [];
        $result[''] = '';
        foreach ($products as $product) {
            $result[$product->Id] = $product->Title;
        }
        return $result;
    }

}