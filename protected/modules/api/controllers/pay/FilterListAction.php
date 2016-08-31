<?php
namespace api\controllers\pay;

use api\components\Action;
use api\components\Exception;
use pay\models\Product;

/**
 * Class FilterListAction Returns list of the products
 */
class FilterListAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $manager = $request->getParam('Manager');
        $params = $request->getParam('Params', []);
        $filter = $request->getParam('Filter', []);

        /** @var $product \pay\models\Product */
        $product = Product::model()
            ->byManagerName($manager)
            ->byEventId($this->getEvent()->Id)
            ->find();

        if (!$product) {
            throw new Exception(420);
        }

        $filterResult = $product->getManager()->filter($params, $filter);
        $result = [];
        foreach ($filterResult as $value) {
            $result[] = (object)$value;
        }

        $this->getController()->setResult($result);
    }
}
