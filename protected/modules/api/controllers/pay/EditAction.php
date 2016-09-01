<?php
namespace api\controllers\pay;

use api\components\Exception;
use api\models\Account;
use Aws\Glacier\Model\MultipartUpload\TransferState;
use pay\models\OrderItem;
use pay\models\Product;
use user\models\User;
use Yii;

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
