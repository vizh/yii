<?php
namespace api\controllers\pay;

use api\components\Action;
use api\components\Exception;
use pay\models\Product;

/**
 * Class ProductAction Returns list of products
 */
class ProductAction extends Action
{
    /**
     * @inheritdoc
     * @throws Exception
     */
    public function run()
    {
        $products = Product::model()
            ->byEventId($this->getEvent()->Id)
            ->byDeleted(false)
            ->findAll([
                'order' => '"t"."Priority" DESC, "t"."Id" ASC'
            ]);

        $result = [];
        foreach ($products as $product) {
            $result[] = $this->getAccount()->getDataBuilder()->createProduct($product);
        }

        $this->setResult($result);
    }
}
