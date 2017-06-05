<?php
namespace event\controllers\exclusive\demo2013;

class AlleyAction extends \CAction
{
    private function registerResources()
    {
        $assetPath = \Yii::getPathOfAlias('pay.assets.js.cabinet');
        \Yii::app()->clientScript->registerScriptFile(
            \Yii::app()->assetManager->publish($assetPath.'/register.js')
        );
    }

    public function run($eventIdName, $productId)
    {
        $request = \Yii::app()->getRequest();
        $event = \event\models\Event::model()->byIdName($eventIdName)->find();
        $product = \pay\models\Product::model()->byEventId($event->Id)->findByPk($productId);
        if ($product == null
            || $this->getController()->getProductHash($product, $request->getParam('T')) !== $request->getParam('Hash')
        ) {
            throw new \CHttpException(404);
        }
        $products = [$product];

        $this->registerResources();

        $orderForm = new \pay\models\forms\OrderForm();
        $orderForm->attributes = $request->getParam(get_class($orderForm));
        if ($request->getIsPostRequest() && $orderForm->validate()) {
            if (!empty($orderForm->Items)) {
                if (sizeof($orderForm->Items) !== 1) {
                    $orderForm->addError('Items', \Yii::t('app', 'Вы пытаетесь приобрести специальную услугу. Убедитесь, что в числе получателей только одна персона.'));
                } else {
                    $owner = \user\models\User::model()->byRunetId($orderForm->Items[0]['RunetId'])->find();
                    if ($owner == null) {
                        $orderForm->addError('Items', \Yii::t('app', 'Вы не указали получателя товара'));
                    }
                }

                if (!$orderForm->hasErrors()) {
                    try {
                        $product->getManager()->createOrderItem(\Yii::app()->user->getCurrentUser(), $owner);
                    } catch (\pay\components\Exception $e) {
                        if ($e->getCode() !== 701) {
                            $orderForm->addError('Items', $e->getMessage());
                        }
                    }
                }
            }

            if (!$orderForm->hasErrors()) {
                $this->getController()->redirect(
                    $this->getController()->createUrl('/pay/cabinet/index', ['eventIdName' => $event->IdName])
                );
            }
        }

        $this->getController()->bodyId = 'event-register';
        $this->getController()->render('pay.views.cabinet.register', [
            'orderForm' => $orderForm,
            'registerForm' => new \user\models\forms\RegisterForm(),
            'products' => $products,
            'event' => $event
        ]);
    }
}
