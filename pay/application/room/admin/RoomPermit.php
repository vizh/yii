<?php
AutoLoader::Import('library.rocid.pay.*');

class RoomPermit extends AdminCommand
{
  private $hotels = array(
    1 => 'ЛЕСНЫЕ ДАЛИ',
    2 => 'ПОЛЯНЫ',
    3 => 'НАЗАРЬЕВО'
  );

  const count = 5;

  private $eventId = 245;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($hotel = 1)
  {
    ini_set("memory_limit", "512M");
    set_time_limit(84600);

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
    $command->bindValue(':EventId', $this->eventId);
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
    $criteria->order = 'Owner.LastName, Owner.FirstName';

    $offset = Registry::GetRequestVar('offset', null);

    if ($offset === null)
    {
      $count = OrderItem::model()->with(array('Product' => array('together' => true), 'Owner' => array('together' => true)))->count($criteria);
      $output .= '<p>Всего путевок: ' . $count . '</p> <br>';
      $offset = 0;
      while ($offset < $count)
      {

        $output .= '<a target="_blank" href="http://pay.rocid.ru/admin/room/permit/' . $hotel . '/?offset=' . $offset . '">'
          . ($offset+1) . ' &mdash; ' . min(($offset+self::count), $count) . '</a> <br><br>';
        $offset += self::count;
      }

      echo $output;
    }
    else
    {
      $criteria->offset = $offset;
      $criteria->limit = self::count;

      /** @var $orderItems OrderItem[] */
      $orderItems = OrderItem::model()->with(array('Product' => array('together' => true), 'Owner' => array('together' => true)))->findAll($criteria);

      Yii::import('ext.qrcode.Barcode');
      Yii::import('ext.html2pdf.HTML2PDF');

      $view = new View();
      $view->SetTemplate('head');

      $pdfContent = $view->__toString();
      $page2Tpl = $this->getCommonInfo();
      foreach ($orderItems as $item)
      {
        $pdfContent .= $this->getPage1Tpl($item);
        $pdfContent .= $page2Tpl;
      }

      $html2pdf = new HTML2PDF('P');
      $html2pdf->setDefaultFont('dejavusanscondensed');
      $html2pdf->WriteHTML($pdfContent);
      $html2pdf->Output('hotel_' . $hotel . '_' . ($offset+1) . '-' . ($offset + self::count) . '.pdf', 'D');
      exit();
    }
  }

  /**
   * Шаблон первой страницы путёвки
   * @param OrderItem $orderItem
   * @return string
   */
  private function getPage1Tpl($orderItem)
  {
    $view = new View();
    $view->SetTemplate('page-1');

    $view->OrderItem = $orderItem;

    $eventUser = EventUser::GetByUserEventId($orderItem->Owner->UserId, $this->eventId);
    if (!empty($eventUser))
    {
      $view->Role = $eventUser->EventRole->Name;
    }

    $criteria = new CDbCriteria();
    $criteria->condition = 't.OwnerId = :OwnerId AND t.Paid = :Paid AND Product.EventId = :EventId AND Product.Manager = :Manager';
    $criteria->params = array(
      ':OwnerId' => $orderItem->OwnerId,
      ':Paid' => 1,
      ':EventId' => $this->eventId,
      ':Manager' => 'FoodProductManager'
    );
    /** @var $foodItems OrderItem[] */
    $foodItems = OrderItem::model()->with(array('Product' => array('together' => true)))->findAll($criteria);
    $food = array();
    foreach ($foodItems as $item)
    {
      $food[] = $item->Product->Title;
    }

    $view->Food = $food;

    return $view->__toString();
  }


  /**
   * Общая информация
   * @return string
   */
  private function getCommonInfo()
  {
    $view = new View();
    $view->SetTemplate('common-info');
    return $view->__toString();
  }
}
