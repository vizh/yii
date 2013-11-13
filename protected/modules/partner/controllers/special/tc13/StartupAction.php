<?php
namespace partner\controllers\special\tc13;

class StartupAction extends \partner\components\Action
{
  public function run()
  {
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."Id"', [1428, 1429]);
    $products = \pay\models\Product::model()->findAll($criteria);

    $result = null;

    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $test = \competence\models\Test::model()->findByPk(4);
      $product = $request->getParam('product');
      $prefix = $product == 1428 ? 'wp' : 'np';
      $userKey = $prefix . \application\components\utility\Texts::GenerateString(6, true);
      $hash = $test->getKeyHash($userKey);
      $result = \Yii::app()->createUrl('/event/view/index', [
        'userKey' => $userKey,
        'userHash' => $hash,
        'idName' => $this->getEvent()->IdName
      ]);
    }

    $this->getController()->render('tc13/startup', ['products' => $products, 'result' => $result]);
  }
}