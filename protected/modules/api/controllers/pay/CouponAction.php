<?php
namespace api\controllers\pay;

use api\components\Exception as ApiException;
use api\models\ExternalUser;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use pay\components\Exception as PayException;
use pay\models\Coupon;

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
        /** @var $coupon Coupon */
        $coupon = Coupon::model()
            ->byCode($this->getRequestParam('CouponCode'))
            ->byEventId($this->getEvent()->Id)
            ->byDeleted(false)
            ->find();

        if ($coupon === null) {
            throw new ApiException(406);
        }

        $payer = null;
        $owner = null;
        if ($this->hasRequestParam('ExternalId')) {
            $externalUser = ExternalUser::model()
                ->byExternalId($this->getRequestParam('ExternalId'))
                ->byAccountId($this->getAccount()->Id)
                ->find();

            if ($externalUser === null) {
                throw new ApiException(3003, [$this->getRequestParam('ExternalId')]);
            }

            $payer = $owner = $externalUser;
        } else {
            $payer = $this->getRequestedPayer();
            $owner = $this->getRequestedOwner();
        }

        $product = null;
        if ($this->hasRequestParam('ProductId')) {
            $product = $this->getRequestedProduct();
        }

        try {
            $coupon->activate($payer, $owner, $product);
        } catch (PayException $e) {
            throw new ApiException(408, [$e->getCode(), $e->getMessage()], $e);
        }

        $result = new \stdClass();
        $result->Discount = $coupon->getManager()->getDiscountString();
        $this->setResult($result);
    }
}
