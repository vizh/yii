<?php
namespace api\controllers\pay;

use api\components\Action;
use pay\models\Product;

class ProductsAction extends Action
{
    public function run()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $model = Product::model()->byEventId($this->getEvent()->Id)->byDeleted(false);
        if ($request->getParam('OnlyPublic')) {
            $model->byPublic(true);
        }

        $products = $model->findAll(['order' => '"t"."Priority" DESC, "t"."Id" ASC']);
        $result = [];
        foreach ($products as $product) {
            $result[] = $this->getAccount()->getDataBuilder()->createProduct($product);
        }
        $this->setResult($result);
    }
}