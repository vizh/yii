<?php
namespace api\controllers\pay;

class FilterListAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $manager = $request->getParam('Manager');
    $params = $request->getParam('Params', array());
    $filter = $request->getParam('Filter', array());

    /** @var $product \pay\models\Product */
    $product = \pay\models\Product::model()
        ->byManagerName($manager)
        ->byEventId($this->getEvent()->Id)->find();

    if ($product === null)
    {
      throw new \api\components\Exception(420);
    }

    $filterResult = $product->getManager()->filter($params, $filter);
    $result = array();
    foreach ($filterResult as $value)
    {
      $result[] = (object) $value;
    }

    $this->getController()->setResult($result);
  }
}