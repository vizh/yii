<?php
use \pay\components\Controller;
use pay\models\Product;
use user\models\User;
use pay\components\CodeException as PayCodeException;
use pay\components\Exception as PayException;
use pay\models\OrderItem;
use \application\components\controllers\AjaxController as TraitAjaxController;

class AjaxController extends Controller
{
    use TraitAjaxController;

    public function actions()
    {
        return array(
            'couponactivate' => '\pay\controllers\ajax\CouponActivateAction',
            'couponinfo' => '\pay\controllers\ajax\CouponInfoAction',
            'userdata' => '\pay\controllers\ajax\UserDataAction',
            'edituserdata' => '\pay\controllers\ajax\EditUserDataAction',
        );
    }

    /**
     * Ajax добавление товара
     * @param int $ownerRunetId
     * @param int $productId
     * @return string
     */
    public function actionAddOrderItem($ownerRunetId, $productId)
    {
        $result = new \stdClass();
        try {
            $owner = User::model()->byRunetId($ownerRunetId)->find();
            if ($owner === null) {
                throw new PayCodeException(PayCodeException::NO_EXISTS_ORDER_ITEM_OWNER);
            }

            $product = Product::model()->byPublic(true)->findByPk($productId);
            if ($product === null) {
                throw new PayCodeException(PayCodeException::NO_EXISTS_PRODUCT);
            }

            $orderItem = $product->getManager()->createOrderItem($this->getUser(), $owner);
            $result->success = true;
            $result->orderItemId = $orderItem->Id;
            $result->price = $orderItem->getPriceDiscount();
        } catch (PayException $e) {
            $result->error = true;
            $result->message = $e->getMessage();
        }
        $this->returnJSON($result);
    }

    /**
     * Ajax удаление заказа
     * @param int $id
     * @return string
     */
    public function actionDeleteOrderItem($id) {
        $result = new \stdClass();
        try {
            $orderItem = OrderItem::model()->byPayerId($this->getUser()->Id)->byPaid(false)->findByPk($id);
            if ($orderItem === null) {
                throw new PayCodeException(PayCodeException::NO_EXISTS_ORDER_ITEM);
            }
            $orderItem->delete();
            $result->success = true;
        } catch (PayException $e) {
            $result->error = true;
            $result->message = $e->getMessage();
        }
        $this->returnJSON($result);
    }
}
