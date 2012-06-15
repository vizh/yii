<?php
AutoLoader::Import('library.rocid.pay.*');

class RoomTest extends AdminCommand
{
  private function printCell($text)
  {
    echo '<td>' . $text . '</td>';
  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.Booked IS NOT NULL AND t.Paid = 0 AND t.Deleted = 0';
    $criteria->order = 't.Booked';

    /** @var $items OrderItem[] */
    $items = OrderItem::model()->findAll($criteria);

    echo '<table>';
    foreach ($items as $item)
    {
      echo '<tr>';
      $this->printCell($item->Product->GetAttribute('Hotel')->Value);
      $this->printCell($item->Product->GetAttribute('Category')->Value);
      $this->printCell(date('d.m.Y', strtotime($item->GetParam('DateIn')->Value)) . '&mdash;' . date('d.m.Y', strtotime($item->GetParam('DateOut')->Value)));
      $this->printCell($item->Payer->LastName . ' ' . $item->Payer->FirstName . ' ' . $item->Payer->FatherName );

      $phones = array();
      foreach ($item->Payer->Phones as $phone)
      {
        $phones[] = $phone->Phone;
      }

      $this->printCell(implode(';', $phones));
      $this->printCell(!empty($item->Payer->Emails[0]) ? $item->Payer->Emails[0]->Email : $item->Payer->Email);

      echo '</tr>';
    }

    echo '</table>';


//    $managerName = 'RoomProductManager';
//
//    $dates = array('2012-04-17', '2012-04-20');
//
//    $product = Product::GetByManager($managerName, 245);
//    if ($product != null)
//    {
//      $manager = $product->ProductManager();
//      //'DateIn' => '2012-04-19', 'DateOut' => '2012-04-20'
//
//      $filter = array
//      (
//          'DateIn' => '2012-04-17',
//          'DateOut' => '2012-04-20',
//          'Hotel' => 'ЛЕСНЫЕ ДАЛИ',
//          'Housing' => '1 корпус',
//          'Category' => 'аппартаменты',
//          'RoomCount' => 2,
//          'SleepCount' => 4,
//          'RoomDescription' => '2-х спальн.',
//          'AdditionalDescription' => '2-х местн.диван',
//          'Price' => 9750
//      );
//
//      //$product = $manager->GetFilterProduct($filter);
//      //print_r($product);
//
//      $result = $manager->Filter(array('Hotel' => 'НАЗАРЬЕВО', 'Housing' => '1 корпус'), array('SleepCount', 'BedCount', 'RoomDescription'));
//      print_r($result);
//
//      //$user = User::GetByRocid(321);
//      //$product->ProductManager()->CreateOrderItem($user, $user, array('DateIn' => '2012-04-19', 'DateOut' => '2012-04-20'));
//    }


  }
}

/*
$offset = 0;
$criteria = new CDbCriteria();
$criteria->condition = 't.Manager = :Manager AND t.EventId = :EventId';
$criteria->params = array(':Manager' => 'RoomProductManager', ':EventId' => 245);
$criteria->offset = $offset;
$criteria->limit = 200;

$products = Product::model()->with('Attributes', 'Prices')->findAll($criteria);

foreach ($products as $product)
{
  $visible = $product->GetAttribute('Visible');
  if ($visible === null)
  {
    $hotel = $product->GetAttribute('Hotel');
    if ($hotel->Value == 'ЛЕСНЫЕ ДАЛИ')
    {
      $product->AddAttribute('Visible', 0);
    }
    else
    {
      $product->AddAttribute('Visible', 1);
    }
  }
}

return;*/
