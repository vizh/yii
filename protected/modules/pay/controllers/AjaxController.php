<?php
use application\components\controllers\AjaxController as TraitAjaxController;
use event\models\UserData;
use pay\components\CodeException as PayCodeException;
use pay\components\Controller;
use pay\components\Exception as PayException;
use pay\models\OrderItem;
use pay\models\Product;
use user\models\User;

class AjaxController extends Controller
{
    use TraitAjaxController;

    public function actions()
    {
        return [
            'couponactivate' => '\pay\controllers\ajax\CouponActivateAction',
            'couponinfo' => '\pay\controllers\ajax\CouponInfoAction',
            'userdata' => '\pay\controllers\ajax\UserDataAction',
            'edituserdata' => '\pay\controllers\ajax\EditUserDataAction',
        ];
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
    public function actionDeleteOrderItem($id)
    {
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

    /**
     * @param RUNET -ID пользователя $id
     * @throws CHttpException
     */
    public function actionCheckUserData($id)
    {
        $user = User::model()->byRunetId($id)->find();
        if ($user === null) {
            throw new \CHttpException(404);
        }

        $result = new \stdClass();
        $data = new UserData();
        $data->EventId = $this->getEvent()->Id;
        $manager = $data->getManager();

        $result->success = true;
        if ($manager->hasDefinitions(true)) {
            $result->attributes = UserData::getDefinedAttributeValues($this->getEvent(), $user);
            foreach ($manager->getGroups() as $group) {
                foreach ($group->getDefinitions() as $definition) {
                    $name = $definition->name;
                    if (!$definition->public || array_key_exists($name, $result->attributes)) {
                        continue;
                    }
                    $result->success = false;
                    $result->attributes[$name] = null;
                }
            }
        }
        $this->returnJSON($result);
    }

    /**
     * @param int $runetId
     * @throws CHttpException
     */
    public function actionEditUserData($runetId)
    {
        $user = User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new \CHttpException(404);
        }

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();

        $data = new UserData();
        $data->EventId = $this->getEvent()->Id;
        $data->UserId = $user->Id;
        $data->CreatorId = $this->getUser()->Id;
        $manager = $data->getManager();
        $manager->setAttributes($request->getParam(get_class($manager)));

        $result = new \stdClass();
        $result->success = true;
        if ($manager->validate(null, true)) {
            $data->save(false);
        } else {
            $result->success = false;
            $result->errors = $manager->getErrors();
        }
        $this->returnJSON($result);
    }
}
