<?php
namespace ruvents\controllers\product;

use pay\models\Product;
use pay\models\ProductGet;
use ruvents\components\Exception;

class ProductGetListAction extends \ruvents\components\Action
{
    public function run($productId, $fromTime = null)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['User'];
        $criteria->order = '"t"."CreationTime" ASC';

        $product = Product::model()
            ->byEventId($this->getEvent()->Id)
            ->findByPk($productId);

        if ($product == null) {
            throw new Exception(401, $productId);
        }

        $criteria->addCondition('"t"."ProductId" = :ProductId');
        $criteria->params['ProductId'] = $product->Id;

        if (!empty($fromTime)) {
            $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $fromTime);

            if ($datetime === false) {
                throw new Exception(900, 'FromUpdateTime');
            }

            $criteria->addCondition('"t"."CreationTime" >= :Time');
            $criteria->params['Time'] = $datetime->format('Y-m-d H:i:s');
        }

        $gets = ProductGet::model()
            ->findAll($criteria);

        $result = [];

        foreach ($gets as $get) {
            $item = new \stdClass();
            $item->RunetId = $get->User->RunetId;
            $item->ProductId = $get->ProductId;
            $item->CreationTime = $get->CreationTime;
            $result[] = $item;
        }

        $this->renderJson($result);
    }
}