<?php
namespace ruvents\controllers\product;

class ProductGetListAction extends \ruvents\components\Action
{
  public function run($productId, $fromTime = null)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = ['User'];
    $criteria->order = '"t"."CreationTime" ASC';

    $product = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->findByPk($productId);
    if ($product == null)
      throw new \ruvents\components\Exception(401,[$productId]);

    $criteria->addCondition('"t"."ProductId" = :ProductId');
    $criteria->params['ProductId'] = $product->Id;

    if (!empty($fromTime))
    {
      $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $fromTime);
      if ($datetime === false)
        throw new \ruvents\components\Exception(321);

      $criteria->addCondition('"t"."CreationTime" >= :Time');
      $criteria->params['Time'] = $datetime->format('Y-m-d H:i:s');
    }

    $gets = \pay\models\ProductGet::model()->findAll($criteria);
    $result = [];
    foreach ($gets as $get)
    {
      $item = new \stdClass();
      $item->RunetId = $get->User->RunetId;
      $item->ProductId = $get->ProductId;
      $item->CretionTime = $get->CreationTime;
      $result[] = $item;
    }

    $this->renderJson($result);
  }
} 