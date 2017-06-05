<?php
namespace api\controllers\pay;

use api\components\Exception;
use api\models\Account;
use nastradamus39\slate\annotations\Action\Param as ApiParam;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;

/**
 * Class EditAction
 *
 * Редактирование позиции заказа.
 *
 * @param ProductId int
 * @param OrderItemId int
 * @param PayerRunetId int
 * @param OwnerRunetId int
 *
 * @package api\controllers\pay
 */
class EditAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Редактирование",
     *     description="Редактирование позиций заказа",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/edit",
     *          body="",
     *          params={
     *              @ApiParam(title="OrderItemId",     mandatory="Y",  description="Идентификатор заказа."),
     *              @ApiParam(title="PayerRunetId",    mandatory="Y",  description="Идентификатор плательщика."),
     *              @ApiParam(title="ProductId",       mandatory="Y",  description="Идентификатор товара."),
     *              @ApiParam(title="OwnerRunetId",    mandatory="Y",  description="Идентификатор получателя товара.")
     *          },
     *          response=@Response(body="{'Success': 'true'}")
     *     )
     * )
     */
    public function run()
    {
        // Редактирование позиций заказа позволено только для собственных мероприятий
        if ($this->getAccount()->Role !== Account::ROLE_OWN) {
            throw new Exception(104);
        }

        $actionAdd = new AddAction($this->getController(), $this->id);
        $actionDel = new DeleteAction($this->getController(), $this->id);

        $actionDel->run();
        $actionAdd->run();

        $this->setSuccessResult();
    }
}
