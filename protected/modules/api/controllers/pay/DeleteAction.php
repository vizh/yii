<?php

namespace api\controllers\pay;

use api\components\Action;
use api\components\Exception;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;

class DeleteAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Удаление",
     *     description="Удаление заказа",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/delete",
     *          params={
     *              @Param(title="OrderItemId", type="Число", description="Идентификатор заказа."),
     *              @Param(title="PayerRunetId", type="Число", description="Идентификатор плательщика.")
     *          },
     *          response=@Response(body="{'Success': 'true'}")
     *     )
     * )
     */
    public function run()
    {
        if ($this->getRequestedOrderItem()->delete() === false) {
            throw new Exception(412);
        }

        $this->setSuccessResult();
    }
}
