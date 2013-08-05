<?php
namespace api\controllers\pay;

class ProductAction extends \api\components\Action
{
  public function run()
  {
    $products = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->findAll(
      ['order' => '"t"."Priority" DESC, "t"."Id" ASC']
    );
    $result = array();
    foreach ($products as $product)
    {
      $result[] = $this->getAccount()->getDataBuilder()->createProduct($product);
    }
    $this->getController()->setResult($result);
  }
}
