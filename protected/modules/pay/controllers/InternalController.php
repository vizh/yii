<?php


class InternalController extends \application\components\controllers\PublicMainController
{

//  public function actionClear()
//  {
//    return;
//    /** @var $products \pay\models\Product[] */
//    $products = \pay\models\Product::model()->byEventId(422)->byManagerName('RoomProductManager')->findAll();
//
//    foreach ($products as $product)
//    {
//      foreach ($product->Attributes as $attr)
//      {
//        //$attr->delete();
//      }
//      //$product->delete();
//    }
//    echo 'OK';
//  }

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
    'Price' => 12,
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
    echo 'empty';
    return;

    $parser = new \application\components\parsing\CsvParser($_SERVER['DOCUMENT_ROOT'] . '/files/ld-rooms.csv');
    $parser->SetInEncoding('utf-8');
    //$results = $parser->Parse($this->fieldMap, true);

//    echo '<pre>';
//    print_r($results);
//    echo '</pre>';

    return;
    foreach ($results as $result)
    {
      $product = new \pay\models\Product();
      $product->ManagerName = 'RoomProductManager';
      $product->Title = 'Участие в объединенной конференции РИФ+КИБ 2013 с проживанием';
      $product->EventId = 422;
      $product->Unit = 'усл.';
      $product->EnableCoupon = false;
      $product->Public = false;
      $product->save();

      $price = new \pay\models\ProductPrice();
      $price->ProductId = $product->Id;
      $price->Price = $result->Price;
      $price->StartTime = '2013-03-14 09:00:00';
      $price->save();

      foreach ($this->fieldMap as $key => $value)
      {
//        if ($key == 'EuroRenovation')
//        {
//          $result->$key = $result->$key == 1 ? 'да' : 'нет';
//        }
        $product->getManager()->$key = trim($result->$key);
      }
      $product->getManager()->Visible = 0;
    }

    echo 'done';
    echo '<pre>';
    print_r($results);
    echo '</pre>';
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
}
