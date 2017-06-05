<?php

class EventController extends \runetid\components\Controller
{
    public function actionTechCrunch()
    {
        \Yii::app()->getClientScript()->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true', CClientScript::POS_BEGIN);
        \Yii::app()->getClientScript()->registerScriptFile('/modules'.$this->layout.'/javascripts/contact.js', CClientScript::POS_BEGIN);
        \Yii::app()->getClientScript()->registerScriptFile('/modules'.$this->layout.'/javascripts/map.js', CClientScript::POS_BEGIN);

        $eventId = 370;
        $products = \pay\models\Product::GetByEventId($eventId);

        $request = \Yii::app()->getRequest();
        $orderForm = new \runetid\components\form\OrderForm();
        $orderForm->attributes = $request->getParam(get_class($orderForm));
        if ($request->getIsPostRequest()) {
            \Yii::app()->session['order_form'] = $orderForm->attributes;
            $this->redirect(
                $this->createUrl('/runetid/pay/owners', ['eventId' => $eventId])
            );
        }

        $this->render('techcrunch', [
            'products' => $products,
            'orderForm' => $orderForm
        ]);
    }
}

?>
