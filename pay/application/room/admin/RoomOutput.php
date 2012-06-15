<?php
AutoLoader::Import('library.rocid.pay.*');

class RoomOutput extends AdminCommand
{
  private $hotels = array(
    1 => 'ЛЕСНЫЕ ДАЛИ',
    2 => 'ПОЛЯНЫ',
    3 => 'НАЗАРЬЕВО'
  );

  /**
   * @var CDbConnection
   */
  private $rifDB;

  /**
   * @return CDbConnection
   */
  private function rifDB()
  {
    if (empty($this->rifDB))
    {
      $this->rifDB = new CDbConnection('mysql:host=109.234.156.205;dbname=intforum', 'intforum', 'tahshi2ri8Kaekae');
    }
    return $this->rifDB;
  }

  /**
   * Основные действия комманды
   * @param int $hotel
   * @return void
   */
  protected function doExecute($hotel = 1)
  {
    ini_set("memory_limit", "512M");

    $command = $this->rifDB()->createCommand();
    $temp = $command->select('*')->from('ext_living_users')->queryAll();

    $living = array();
    foreach ($temp as $value)
    {
      $owner = $value['owner'];
      $companion = $value['companion'];
      if (!isset($living[$owner]))
      {
        $living[$owner] = array();
      }
      $living[$owner][] = $companion;
    }

    $eventId = 245;
    $manager = 'RoomProductManager';
    if (!isset($this->hotels[$hotel]))
    {
      echo 'Не верный номер отеля';
      return;
    }
    $hotelName = $this->hotels[$hotel];

    $output = '<h1>' . $hotelName . '</h1>';

    $sql = "SELECT p.ProductId FROM Mod_PayProduct p
                LEFT JOIN Mod_PayProductAttribute pa ON p.ProductId = pa.ProductId
                WHERE p.EventId = :EventId AND p.Manager = :Manager AND pa.Name = :Name AND pa.Value = :Value";

    $command = Registry::GetDb()->createCommand($sql);
    $command->bindValue(':EventId', $eventId);
    $command->bindValue(':Manager', $manager);
    $command->bindValue(':Name', 'Hotel');
    $command->bindValue(':Value', $hotelName);

    $result = $command->queryAll();

    $productIdList = array();
    foreach ($result as $row)
    {
      $productIdList[] = $row['ProductId'];
    }

    $criteria = new CDbCriteria();
    $criteria->condition = 't.Paid = :Paid OR t.Deleted = :Deleted';
    $criteria->params = array(':Paid' => 1, ':Deleted' => 0);
    $criteria->addInCondition('Product.ProductId', $productIdList);
    $criteria->order = 'Product.ProductId';

    /** @var $orderItems OrderItem[] */
    $orderItems = OrderItem::model()->with(array('Product' => array('together' => true), 'Product.Attributes', 'Owner', 'Params'))->findAll($criteria);

    $output .= '<table border="1" cellspacing="0" cellpadding="3">';
    foreach ($orderItems as $item)
    {
      $output .= '<tr>';
      $output .= $this->printCell($item->Product->GetAttribute('Housing')->Value);
      $output .= $this->printCell($item->Product->GetAttribute('Number')->Value);

      $user = $item->Owner;
      $outputUser = $user->LastName . ' ' . $user->FirstName . ' ' . $user->FatherName;

      if (isset($living[$user->RocId]))
      {
        $criteria = new CDbCriteria();
        $criteria->addInCondition('t.RocId',$living[$user->RocId]);
        $users = User::model()->findAll($criteria);
        foreach ($users as $user)
        {
          $outputUser .= '<br>' . $user->LastName . ' ' . $user->FirstName . ' ' . $user->FatherName;
        }
      }
      $output .= $this->printCell($outputUser);

      $output .= $this->printCell(date('d.m', strtotime($item->GetParam('DateIn')->Value)));
      $output .= $this->printCell(date('d.m', strtotime($item->GetParam('DateOut')->Value)));

      $booked = $item->Paid == 1 ? '&nbsp;' : 'бронь до ' . date('d.m.Y H:i', strtotime($item->Booked));
      $output .= $this->printCell($booked);

      $output .= '</tr>';
    }
    $output .= '</table>';


    echo $output;
  }

  private function printCell($text)
  {
    return '<td>' . $text . '</td>';
  }
}