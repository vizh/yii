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
 * Экспериментальный метод, позволяющий редактировать позиции заказа.
 *
 * @param OrderItemId int
 * @param PayerRunetId int
 * @param ProductId int
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

        $item = $this->getRequestedOrderItem();
        $item->Product = $this->getRequestedProduct();

        if ($item->save() === false) {
            throw new Exception(100, print_r($item->errors, true));
        }

        $this->setSuccessResult();
    }
}
