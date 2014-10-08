<?php
namespace widget\controllers\pay;

use pay\models\Product;

class IndexAction extends \widget\components\pay\Action
{
    const SessionProductCount = 'ProductCount';

    public function run()
    {
        $request = \Yii::app()->getRequest();
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Priority" DESC, "t"."Id" ASC';
        $criteria->addCondition('"t"."ManagerName" != \'Ticket\'');
        if ($this->getController()->getWidgetParamValue('products') !== null) {
            $criteria->addInCondition('"t"."Id"', $this->getController()->getWidgetParamValue('products'));
        }

        $products = Product::model()->byEventId($this->getEvent()->Id)->byPublic(true)->findAll($criteria);
        if ($request->getIsPostRequest())
        {
            \Yii::app()->session[self::SessionProductCount] = $request->getParam('ProductCount', []);
            $this->getController()->gotoNextStep();
        }
        $this->getController()->render('index', ['products' => $products, 'event' => $this->getEvent()]);
    }
}