<?php
AutoLoader::Import('library.rocid.pay.*');

class RoomBook extends AdminCommand
{
  /**
   * Основные действия комманды
   * @param int $roomId
   * @param int $rocId
   * @return void
   */
  protected function doExecute($roomId = null, $rocId = null)
  {
    $eventId = 245;
    $manager = 'RoomProductManager';

    if (empty($roomId))
    {
      if (Yii::app()->getRequest()->getIsPostRequest())
      {
        $hotel = Registry::GetRequestVar('hotel');
        if (! empty($hotel))
        {
          $sql = "SELECT p.ProductId FROM Mod_PayProduct p
            LEFT JOIN Mod_PayProductAttribute pa ON p.ProductId = pa.ProductId
            WHERE p.EventId = :EventId AND p.Manager = :Manager AND pa.Name = :Name AND pa.Value = :Value";

          $command = Registry::GetDb()->createCommand($sql);
          $command->bindValue(':EventId', $eventId);
          $command->bindValue(':Manager', $manager);
          $command->bindValue(':Name', 'hotel');
          $command->bindValue(':Value', $hotel);

          $result = $command->queryAll();

          $productIdList = array();
          foreach ($result as $row)
          {
            $productIdList[] = $row['ProductId'];
          }

          if (!empty($productIdList))
          {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('t.ProductId' ,$productIdList);
            $criteria->order = 't.ProductId';

            /** @var $products Product[] */
            $products = Product::model()->with('Attributes')->findAll($criteria);


            $this->view->Hotel = $hotel;
            $this->view->Products = '';
            foreach ($products as $product)
            {
              $view = new View();
              $view->SetTemplate('product-row');

              $view->ProductId = $product->ProductId;
              $view->Housing = $product->GetAttribute('Housing')->Value;
              $view->Category = $product->GetAttribute('Category')->Value;
              $view->Number = $product->GetAttribute('Number')->Value;
              $view->Price = $product->GetAttribute('Price')->Value;
              $view->Visible = $product->GetAttribute('Visible')->Value;

              $criteria = new CDbCriteria();
              $criteria->condition = 't.ProductId = :ProductId AND (t.Paid = :Paid OR t.Deleted = :Deleted)';
              $criteria->params = array(':ProductId' => $product->ProductId, ':Paid' => 1, ':Deleted' => 0);

              /** @var $items OrderItem[] */
              $items = OrderItem::model()->with('Payer', 'Params')->findAll($criteria);

              $start = '2012-04-17';
              $temp = array();
              foreach ($items as $item)
              {
                $offset = intval((strtotime($item->GetParam('DateIn')->Value) - strtotime($start)) / (24*60*60));
                $temp[$offset] = $item;
              }
              $items = $temp;
              $keys = array_keys($items);
              sort($keys, SORT_NUMERIC);
              $view->Items = $items;
              $view->Keys = $keys;
              $view->Max = 3;

              $this->view->Products .= $view;
            }


          }
        }
      }
    }
    else
    {

    }

    echo $this->view;
  }
}
