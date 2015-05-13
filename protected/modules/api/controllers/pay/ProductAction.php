<?php
namespace api\controllers\pay;

use pay\models\Product;

class ProductAction extends \api\components\Action
{
  public function run()
  {
    $products = Product::model()->byEventId($this->getEvent()->Id)->byDeleted(false)->findAll(
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
