<?php

class InternalController extends \application\components\controllers\PublicMainController
{

  const EventId = 789;

  public function actionClear()
  {
    echo 'closed';
    return;
    /** @var $products \pay\models\Product[] */
    $products = \pay\models\Product::model()->byEventId(self::EventId)->byManagerName('RoomProductManager')->findAll();

    foreach ($products as $product)
    {
      foreach ($product->Attributes as $attr)
      {
        $attr->delete();
      }
      $product->delete();
    }
    echo 'OK';
  }

  public $fieldMap = array(
    'TechnicalNumber' => 0,
    'Hotel' => 1,
    'Housing' => 2,
    'Category' => 3,
    'Number' => 4,
    'EuroRenovation' => 5,
    'RoomCount' => 6,
    'PlaceTotal' => 7,
    'PlaceBasic' => 8,
    'PlaceMore' => 9,
    'DescriptionBasic' => 10,
    'DescriptionMore' => 11,
    'Booking' => 12,
    'Price' => 13,
  );

  public $fieldMapPines = array(
    'TechnicalNumber' => 0,
    'Visible' => 1,
    'Hotel' => 2,
    'Housing' => 3,
    'Category' => 4,
    'Number' => 12,
    'EuroRenovation' => 5,
    'RoomCount' => 6,
    'PlaceTotal' => 9,
    'PlaceBasic' => 7,
    'PlaceMore' => 8,
    'DescriptionBasic' => 10,
    'DescriptionMore' => 17,
    'Price' => 16,
  );

  public function actionImportrooms()
  {
    echo 'closed';

    return;
    $parser = new \application\components\parsing\CsvParser($_SERVER['DOCUMENT_ROOT'] . '/files/import_20140305.csv');
    $parser->SetInEncoding('utf-8');
    $parser->SetDelimeter(';');
    $results = $parser->Parse($this->fieldMap, true);

    $results = array_slice($results, 400, 200);

    echo '<pre>';
    print_r($results);
    echo '</pre>';
    return;

    foreach ($results as $result)
    {
      $product = new \pay\models\Product();
      $product->ManagerName = 'RoomProductManager';
      $product->Title = 'Участие в объединенной конференции РИФ+КИБ 2014 с проживанием';
      $product->EventId = self::EventId;
      $product->Unit = 'усл.';
      $product->EnableCoupon = false;
      $product->Public = false;
      $product->save();

      $price = new \pay\models\ProductPrice();
      $price->ProductId = $product->Id;
      $price->Price = $result->Price;
      $price->StartTime = '2014-03-01 09:00:00';
      $price->save();

      if (empty($result->EuroRenovation))
      {
        $result->EuroRenovation = 'нет';
      }
      if (empty($result->Housing))
      {
        $result->Housing = 'Основной корпус';
      }

      foreach ($this->fieldMap as $key => $value)
      {
        switch ($key)
        {
          case 'Booking':
            $booking = trim($result->$key);
            if ($booking == 'САЙТ')
            {
              $product->getManager()->Visible = 1;
            }
            else
            {
              $product->getManager()->Visible = 0;
              if ($booking == 'ОРГКОМ')
              {
                $roomBooking = new \pay\models\RoomPartnerBooking();
                $roomBooking->ProductId = $product->Id;
                $roomBooking->Owner = 'Оргкомитет';
                $roomBooking->DateIn = '2014-04-22';
                $roomBooking->DateOut = '2014-04-25';
                $roomBooking->ShowPrice = false;
                $roomBooking->save();
              }
            }
            break;
          default:
            $product->getManager()->$key = trim($result->$key);
        }
      }

    }

    echo 'done';
    echo '<pre>';
    print_r($results);
    echo '</pre>';
  }

  public function actionFixprice()
  {
    echo 'closed';

    return;
    $products = \pay\models\Product::model()
      ->byEventId(self::EventId)->byManagerName('RoomProductManager')->findAll();

    foreach ($products as $product)
    {
      $price = $product->getManager()->Price;
      $price = str_replace(',', '', $price);
      $product->getManager()->Price = intval($price);

      $priceModel = $product->Prices[0];
      $priceModel->Price = intval($price);
      $priceModel->save();
    }
  }

  public function actionCreatefood()
  {
    return;
    $foods = array(
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 16 апреля, обед (пансионат)' => 600,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 16 апреля, ужин' => 500,

      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 17 апреля, завтрак' => 400,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 17 апреля, обед (пансионат)' => 600,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 17 апреля, обед (Андерсон)' => 800,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 17 апреля, ужин' => 500,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 17 апреля, банкет' => 2000,

      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 18 апреля, завтрак' => 400,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 18 апреля, обед (пансионат)' => 600,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 18 апреля, обед (Андерсон)' => 800,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 18 апреля, ужин' => 500,

      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 19 апреля, завтрак' => 400,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 19 апреля, обед (пансионат)' => 600,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 19 апреля, обед (Андерсон)' => 800,
      'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 19 апреля, ужин' => 500,
    );

    foreach ($foods as $title => $price)
    {
      $product = new \pay\models\Product();
      $product->ManagerName = 'FoodProductManager';
      $product->Title = $title;
      $product->EventId = 422;
      $product->Unit = 'шт.';
      $product->EnableCoupon = false;
      $product->Public = false;
      $product->save();

      $productPrice = new \pay\models\ProductPrice();
      $productPrice->ProductId = $product->Id;
      $productPrice->Price = $price;
      $productPrice->StartTime = '2013-03-14 09:00:00';
      $productPrice->save();
    }
  }

  public function actionRemovePhysicalBooked()
  {
    $orderItems = \pay\models\OrderItem::model()->byEventId(789)
      ->byPaid(false)->byBooked(false)->byDeleted(false)->findAll();

    foreach ($orderItems as $item)
    {
      if ($item->delete())
      {
        echo $item->Id . ' ' . $item->CreationTime . ' Booked to ' . $item->Booked . '<br>';
      }
    }
  }
}
