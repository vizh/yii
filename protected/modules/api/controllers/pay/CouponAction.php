<?php
namespace api\controllers\pay;

use pay\models\Coupon;
use pay\models\Product;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class CouponAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Купон",
     *     description="Активация купона",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/coupon",
     *          params={
     *              @Param(title="CouponCode", description="Код купона.", mandatory="Y"),
     *              @Param(title="ExternalId", description="Внешний Id.", mandatory="Y"),
     *              @Param(title="ProductId", description="Идентификатор товара.", mandatory="Y")
     *          },
     *          response=@Response( body="{'Discount':'50%'}" )
     *     )
     * )
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $couponCode = $request->getParam('CouponCode');
        $externalId = $request->getParam('ExternalId');
        $productId = $request->getParam('ProductId');

        /** @var $coupon Coupon */
        $coupon = Coupon::model()
            ->byCode($couponCode)
            ->byEventId($this->getEvent()->Id)
            ->byDeleted(false)
            ->find();

        if ($coupon === null) {
            throw new \api\components\Exception(406);
        }

        $payer = null;
        $owner = null;
        if (!empty($externalId)) {
            $externalUser = \api\models\ExternalUser::model()
                ->byExternalId($externalId)->byAccountId($this->getAccount()->Id)->find();
            if ($externalUser === null) {
                throw new \api\components\Exception(3003, [$externalId]);
            }
            $payer = $owner = $externalUser;
        } else {
            $payer = $this->getRequestedPayer();
            $owner = $this->getRequestedOwner();
        }

        $product = null;
        if (!empty($productId)) {
            $product = Product::model()->findByPk($productId);
        }

        try {
            $coupon->activate($payer, $owner, $product);
        } catch (\pay\components\Exception $e) {
            throw new \api\components\Exception(408, [$e->getCode(), $e->getMessage()], $e);
        }

        $result = new \stdClass();
        $result->Discount = $coupon->getManager()->getDiscountString();
        $this->setResult($result);
    }
}
