<?php
namespace partner\controllers\user;

use application\components\controllers\AjaxController;
use application\components\Exception;
use application\components\traits\LoadModelTrait;
use event\models\Part;
use event\models\Role;
use event\models\UserData;
use partner\components\Action;
use partner\models\forms\user\Participant as ParticipantForm;
use pay\models\OrderItem;
use pay\models\Product;
use user\models\User;
use pay\components\Exception as PayException;
use event\components\UserDataManager;

class EditAction extends Action
{
    use AjaxController;
    use LoadModelTrait;

    public function run($id)
    {
        $user = User::model()->byRunetId($id)->find();
        if ($user === null) {
            throw new \CHttpException(404);
        }

        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $this->processAjaxAction($user);
        }
        $form = new ParticipantForm($this->getEvent(), $user);
        $this->getController()->render('edit', ['form' => $form]);
    }


    /**
     * @param User $user
     * @throws \CHttpException
     */
    private function processAjaxAction(User $user)
    {
        $action = \Yii::app()->getRequest()->getParam('action');
        if ($action !== null) {
            $method = 'actionAjax' . ucfirst($action);
            if (method_exists($this, $method)) {
               $this->returnJSON($this->$method($user));
            }
            throw new \CHttpException(404);
        }
    }

    /**
     * Смена статуса пользователя
     * @param User $user
     * @return array
     * @throws \CHttpException
     * @throws Exception
     */
    private function actionAjaxChangeRole(User $user)
    {
        $event = $this->getEvent();

        $request = \Yii::app()->getRequest();
        $message = $request->getParam('message');

        /** @var Role $role */
        $role = $this->loadModel(Role::className(), $request->getParam('role'), false);
        if (!empty($event->Parts)) {
            /** @var Part $part */
            $part = $this->loadModel(Part::className(), $request->getParam('role'));
            if ($role !== null) {
                $event->registerUserOnPart($part, $user, $role, false, $message);
            } else {
                $event->unregisterUserOnPart($user, $part, $message);
            }
        } else {
            $role !== null ? $event->registerUser($user, $role, false, $message) : $event->unregisterUser($user, $message);
        }
        return ['success' => true];
    }

    /**
     * Добавление опции пользователю
     * @param User $user
     * @throws Exception
     * @throws \CHttpException
     * @throws \pay\components\CodeException
     * @throws \pay\components\MessageException
     */
    private function actionAjaxCreateOrderItem(User $user)
    {
        $product = $this->getProduct();
        try {
            $orderItem = $product->getManager()->createOrderItem($user, $user);
            $orderItem->activate();
            $result = ['success' => true];
        } catch (PayException $e) {
            $result = [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
        $this->returnJSON($result);
    }

    /**
     * Удаляет опцию у пользователя
     * @param User $user
     * @return array
     * @throws \CHttpException
     */
    private function actionAjaxDeleteOrderItem(User $user)
    {
        $product = $this->getProduct();
        $orderItem = OrderItem::model()->byProductId($product->Id)->byAnyOwnerId($user->Id)->byPaid(true)->find();
        if ($orderItem === null) {
            throw new \CHttpException(404);
        }

        $orderItem->deactivate();
        $orderItem->delete();

        return ['success' => true];
    }

    /**
     * Изменяет значения пользовательских свойств
     * @param User $user
     * @return array
     * @throws \CHttpException
     */
    private function actionAjaxEditData(User $user)
    {
        $request = \Yii::app()->getRequest();
        /** @var UserData $data */
        $data = $this->loadModel(UserData::className(), $request->getParam('data'));
        if ($data->UserId !== $user->Id || $data->EventId !== $this->getEvent()->Id) {
            throw new \CHttpException(404);
        }

        $attributes = $request->getParam(UserDataManager::className());
        $manager = $data->getManager();

        $manager->setAttributes($attributes);
        if ($manager->validate()) {
            $data->save();

            $result = [];
            foreach ($data->getManager()->getDefinitions() as $definition) {
                $result[$definition->name] = $definition->getPrintValue($data->getManager());
            }
            return $result;
        } else {
            foreach ($manager->getErrors() as $errors) {
                foreach ($errors as $error) {
                    return ['error' => true, 'message' => $error];
                }
            }
        }
    }

    /**
     * @return Product
     * @throws Exception
     * @throws \CHttpException
     */
    private function getProduct()
    {
        /** @var Product $product */
        $product = $this->loadModel(Product::className(), \Yii::app()->getRequest()->getParam('product'));
        if ($product->EventId !== $this->getEvent()->Id || $product->getPrice() !== 0) {
            throw new \CHttpException(404);
        }
        return $product;
    }
}