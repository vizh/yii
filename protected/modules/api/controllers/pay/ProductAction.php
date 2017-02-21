<?php
namespace api\controllers\pay;

use api\components\Action;
use api\components\Exception;
use pay\models\Product;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

/**
 * Class ProductAction Returns list of products
 */
class ProductAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Список товаров",
     *     description="Список доступных товаров. (Не работает)",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/product",
     *          body="",
     *          params={
     *              @Param(title="OwnerRunetId", description="Идентификатор владельца.")
     *          },
     *          response=@Response( body="[ '{$PRODUCT}' ]" )
     *     )
     * )
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
