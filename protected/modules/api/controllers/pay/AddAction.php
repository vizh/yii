<?php
namespace api\controllers\pay;

use api\components\Action;
use api\components\Exception;
use pay\components\CodeException;
use pay\components\MessageException;
use pay\components\OrderItemCollection;
use pay\models\Coupon;
use Throwable;
use Yii;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class AddAction extends Action
{

    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Добавление",
     *     description="Добавление заказа",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/add",
     *          params={
     *              @Param(title="ProductId", type="строка", defaultValue="", description="Идентификатор товара. Обязательно."),
     *              @Param(title="PayerRunetId", type="строка", defaultValue="", description="Идентификатор плательщика. Обязательно."),
     *              @Param(title="OwnerRunetId", type="строка", defaultValue="", description="Идентификатор получателя товара. Обязательно.")
     *          },
     *          response=@Response( body="{'Id': 'идентификатор элемента заказа','Product': 'объект Product','Owner': 'объект User (сокращенный, только основные данные пользователя)','PriceDiscount': 'цена с учетом скидки','Paid': 'статус оплаты','PaidTime': 'время оплаты','Attributes': 'массив с атрибутами (если заданы)','Discount': 'размер скидки от 0 до 1, где 0 - скидки нет, 1 - скидка 100%','CouponCode': 'код купона, по которому была получена скидка','GroupDiscount': 'была скидка групповая или нет'}" )
     *     )
     * )
     */
    public function run()
    {
        $payer = $this->getRequestedPayer();
        $owner = $this->getRequestedOwner();

        $attrs = Yii::app()
            ->getRequest()
            ->getParam('Attributes', []);

        try {
            $orderItem = $this
                ->getRequestedProduct()
                ->getManager()
                ->createOrderItem($payer, $owner, null, $attrs);

            if ($orderItem->getPrice() === 0) {
                $orderItem->activate();
            }
        } catch (Throwable $e) {
            throw new Exception(408, [$e->getCode(), $e->getMessage()], $e);
        }

        # TODO: delete after edcrunch16
        if ($this->getEvent()->IdName === 'edcrunch16'
            && Yii::app()->getRequest()->getParam('Paid', false)
            && Yii::app()->getRequest()->getParam('PaidHash') === md5(
                $this->getRequestedProduct()->Id.
                $payer->RunetId.
                $owner->RunetId
            )
        ) {
            $coupon = new Coupon();
            $coupon->EventId = $this->getEvent()->Id;
            $coupon->Discount = 100;
            $coupon->Code = $coupon->generateCode();
            $coupon->EndTime = '2016-09-14 23:59:59';
            $coupon->save();
            $coupon->addProductLinks([$this->getRequestedProduct()]);
            $coupon->activate($payer, $owner, $this->getRequestedProduct());
        }

        $collection = OrderItemCollection::createByOrderItems([$orderItem]);

        // toDo: WTF?!
        $result = null;
        foreach ($collection as $item) {
            $result = $this->getAccount()->getDataBuilder()->createOrderItem($item);
            break;
        }

        $this->setResult($result);
    }
}
