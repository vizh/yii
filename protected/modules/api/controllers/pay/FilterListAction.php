<?php
namespace api\controllers\pay;

use api\components\Action;
use api\components\Exception;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use pay\models\Product;

/**
 * Class FilterListAction Returns list of the products
 */
class FilterListAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Товары",
     *     description="Список товаров",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/filterlist",
     *          params={
     *              @Param(title="Manager", description="Идентификатор менеджера.", mandatory="Y"),
     *              @Param(title="Params", description="Параметры поиска.", mandatory="Y"),
     *              @Param(title="Filter", description="Фильтр.", mandatory="N")
     *          },
     *          response=@Response( body="" )
     *     )
     * )
     */
    public function run()
    {
//        tgmsg($_POST);

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

        $this->setResult($result);
    }
}
