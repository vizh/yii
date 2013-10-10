<?php
namespace pay\controllers\cabinet;

class IndexAction extends \pay\components\Action
{
  public function run($eventIdName)
  {
    $this->getController()->setPageTitle('Оплата  / ' .$this->getEvent()->Title . ' / RUNET-ID');

    $finder = \pay\components\collection\Finder::create($this->getEvent()->Id, $this->getUser()->Id);

    $unpaidItems = [];
    foreach ($finder->getUnpaidFreeCollection() as $item)
    {
      if (!isset($unpaidItems[$item->getOrderItem()->ProductId]))
      {
        $unpaidItems[$item->getOrderItem()->ProductId] = [];
      }
      $unpaidItems[$item->getOrderItem()->ProductId][] = $item;
    }

    $allPaidCollections = array_merge($finder->getPaidOrderCollections(), $finder->getPaidFreeCollections());

    $hasRecentPaidItems = false;
    foreach ($allPaidCollections as $collection)
    {
      foreach ($collection as $item)
      {
        /** @var $item \pay\components\OrderItemCollectable */
        if ($item->getOrderItem()->PaidTime > date('Y-m-d H:i:s', time() - 10*60*60))
        {
          $hasRecentPaidItems = true;
          break;
        }
      }
      if ($hasRecentPaidItems)
        break;
    }

    $this->getController()->render('index', array(
      'finder' => $finder,
      'unpaidItems' => $unpaidItems,
      'hasRecentPaidItems' => $hasRecentPaidItems,
      'account' => $this->getAccount()
    ));
  }
}