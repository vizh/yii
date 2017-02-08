<?php
namespace api\controllers\pay;

use api\components\Action;
use pay\models\Product;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

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
     *          response=@Response(body="[{'Id': 'идентификатор','Manager': 'строка, название менеджера (участие, питание и другие)','Title': 'название товара','Price': 'текущая цена','Attributes': 'массив ключ-значение с атрибутами товара'}]")
     *     )
     * )
     */
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