<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.event.*');

class MainStats extends AdminCommand
{

  /**
   * @var Event
   */
  private $event;

  /**
   * Основные действия комманды
   * @param int $eventId
   * @return void
   */
  protected function doExecute($eventId = 0)
  {
    ini_set("memory_limit", "512M");

    $this->event = Event::GetById($eventId);
    if (empty($this->event))
    {
      $this->Send404AndExit();
    }

    $products = Product::GetByEventId($this->event->EventId);
    $list = array();
    foreach ($products as $product)
    {
      if ($product->Manager != 'EventProductManager')
      {
        $list[$product->Manager][] = $product->ProductId;
      }
      else
      {
        $list[] = array($product->ProductId);
      }
    }

    foreach ($list as $key => $value)
    {
      $this->view->Info .= $this->getProductInfo($value, $key);
    }

    $this->view->Title = $this->event->Name;

    echo $this->view;
  }


  private $productResult;
  /**
   * @param int[] $products
   * @param string $manager
   * @return string
   */
  private function getProductInfo($products, $manager)
  {
    $this->productResult = array();
    $view = new View();
    $view->SetTemplate('info');

    $criteria = new CDbCriteria();
    $criteria->distinct = true;
    $criteria->with = array('Orders' => array('select' => false), 'Orders.OrderJuridical' => array('select' => false));
    $criteria->condition = 't.Paid = 1 AND OrderJuridical.Paid = 1';
    $criteria->addInCondition('t.ProductId', $products);

    /** @var $itemRecords OrderItem[] */
    $itemRecords = OrderItem::model()->findAll($criteria);

    $items = array();
    foreach ($itemRecords as $item)
    {
      $items[] = $item->OrderItemId;
      $this->addItemInfo($item, 'juridical');
    }

    $criteria = new CDbCriteria();
    $criteria->with = array('Product', 'Product.Attributes', 'Owner');
    $criteria->condition = 't.Paid = :Paid';
    $criteria->params = array(':Paid' => 1);
    $criteria->addInCondition('t.ProductId', $products);
    $criteria->addNotInCondition('t.OrderItemId', $items);

    $itemRecords = OrderItem::model()->findAll($criteria);
    foreach ($itemRecords as $item)
    {
      $this->addItemInfo($item, 'physical');
    }

    $keys = array_keys($this->productResult);
    sort($keys);
    $view->ResultKeys = $keys;
    $view->Result = $this->productResult;
    if (sizeof($products) == 1)
    {
      $product = Product::GetById($products[0]);
      $view->Title = !empty($product) ? $product->Title : 'Товар не определен';
    }
    else
    {
      $view->Title = $manager;
    }


    if (empty($itemRecords) && empty($items))
    {
      return '';
    }

    return $view;
  }

  /**
   * @param OrderItem $item
   * @param string $type
   */
  private function addItemInfo($item, $type = 'juridical')
  {

    $couponActivated = $item->GetCouponActivated();
    $discount = 0;
    if (!empty($couponActivated))
    {
      $discount = intval($couponActivated->Coupon->Discount * 100);
    }

    if (!isset($this->productResult[$discount]))
    {
      $this->productResult[$discount]['physical']['count'] = 0;
      $this->productResult[$discount]['physical']['total'] = 0;
      $this->productResult[$discount]['juridical']['count'] = 0;
      $this->productResult[$discount]['juridical']['total'] = 0;
    }

    $this->productResult[$discount][$type]['count'] += 1;
    $this->productResult[$discount][$type]['total'] += $item->PriceDiscount();

    if (!isset($this->productResult['all']))
    {
      $this->productResult['all']['physical']['count'] = 0;
      $this->productResult['all']['physical']['total'] = 0;
      $this->productResult['all']['juridical']['count'] = 0;
      $this->productResult['all']['juridical']['total'] = 0;
    }
    $this->productResult['all'][$type]['count'] += 1;
    $this->productResult['all'][$type]['total'] += $item->PriceDiscount();
  }


}