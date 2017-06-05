<?php

class Demo2013Controller extends \application\components\controllers\PublicMainController
{
    public function actions()
    {
        return [
            'alley' => '\event\controllers\exclusive\demo2013\AlleyAction'
        ];
    }

    public function actionExibitionLinks($eventIdName)
    {
        if (\Yii::app()->request->getParam('key') !== '2qDWLBUAxH') {
            throw new CHttpException(404);
        }

        $event = event\models\Event::model()->byIdName($eventIdName)->find();
        $products = pay\models\Product::model()->byEventId($event->Id)->byPublic(false)->findAll();
        $this->render('exibition-links', [
            'event' => $event,
            'products' => $products
        ]);
    }

    public function getProductHash($product, $timestamp)
    {
        return substr(md5($timestamp.$product->Id), 25, 30);
    }
}
