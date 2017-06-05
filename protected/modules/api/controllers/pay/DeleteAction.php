<?php
namespace api\controllers\pay;

use api\components\Exception;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;

class DeleteAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Удаление",
     *     description="Удаление заказа",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/delete",
     *          body="",
     *          params={
     *              @Param(title="OrderItemId", type="", defaultValue="", description="Идентификатор заказа."),
     *              @Param(title="PayerRunetId", type="", defaultValue="", description="Идентификатор плательщика.")
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
