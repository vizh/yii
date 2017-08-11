<?php

namespace api\controllers\pay;

use api\components\Action;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use pay\models\Product;
use Yii;

class ProductsAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Товары",
     *     description="Список доступных товаров",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/products",
     *          body="",
     *          params="",
     *          response=@Response(body="['{$PRODUCT}']")
     *     )
     * )
     */
    public function run()
    {
        $products = Product::model()
            ->byEventId($this->getEvent()->Id)
            ->byDeleted(false)
            ->orderBy(['"t"."Priority"' => SORT_DESC, '"t"."Id"' => SORT_ASC]);

        if ($this->hasRequestParam('OnlyPublic')) {
            $products->byPublic();
        }

        $products = $products->findAll();

        $result = [];
        foreach ($products as $product) {
            $result[] = $this->getAccount()
                ->getDataBuilder()
                ->createProduct($product);
        }

        $this->setResult($result);
    }
}
