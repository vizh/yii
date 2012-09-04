<?php
AutoLoader::Import('utility.source.*');
AutoLoader::Import('library.rocid.pay.*');

class UtilityRoom extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $fieldMap = array(
      'Hotel' => 0,
      'TechnicalNumber' => 1,
      'Housing' => 2,
      'Category' => 3,
      'Number' => 4,
      'EuroRenovation' => 5,
      'RoomCount' => 6,
      'SleepCount' => 7,
      'BedCount' => 8,
      'RoomDescription' => 9,
      'AdditionalDescription' => 10,
      'Price' => 11
    );

    return;

//    $path = $_SERVER['DOCUMENT_ROOT'] . '/temp/rooms-ld.csv';
//    $this->parseRoomFile($path, $fieldMap);
//
//    $path = $_SERVER['DOCUMENT_ROOT'] . '/temp/rooms-p.csv';
//    $this->parseRoomFile($path, $fieldMap);
//
//    $path = $_SERVER['DOCUMENT_ROOT'] . '/temp/rooms-n.csv';
//    $this->parseRoomFile($path, $fieldMap);



  }

  protected function parseRoomFile($path, $fieldMap)
  {
    $parser = new CsvParser($path);
    $parser->UseRuLocale();

    $result = $parser->Parse($fieldMap, true);

    foreach ($result as $roomInfo)
    {
      if (empty($roomInfo->Hotel))
      {
        continue;
      }

      echo 'add room: ' . $roomInfo->TechnicalNumber . '<br>';

      $product = new Product();
      $product->Manager = 'RoomProductManager';
      $product->Title = 'Проживание на РИФ+КИБ 2012';
      $product->Description = '';
      $product->EventId = 245;
      $product->Unit = '';
      $product->Count = null;
      $product->EnableCoupon = null;
      $product->save();

      foreach ($roomInfo as $key => $value)
      {
        $product->AddAttribute($key, $value);
      }

      $product->AddPrice($roomInfo->Price, date('Y-m-d H:i:s'));
    }
  }
}
