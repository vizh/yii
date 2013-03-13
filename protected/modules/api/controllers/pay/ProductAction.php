<?php
namespace api\controllers\pay;
class ProductAction extends \api\components\Action
{
  public function run()
  {
    $productId = \Yii::app()->request->getParam('ProductId', null);
    $product = \pay\models\Product::model()
      ->byEventId($this->getAccount()->EventId)
      ->findByPk($productId);
    
    if ($product == null)
    {
      throw new \api\components\Exception(401, array($runetId));
    }
    
    $this->getController()->setResult(
      $this->getAccount()->DataBuilder()->createProduct($product)
    );
  }
}
