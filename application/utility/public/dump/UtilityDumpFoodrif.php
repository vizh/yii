<?php

class UtilityDumpFoodrif extends AbstractCommand
{

  private $furshetId = 676;
  private $breakfast = array(674, 677, 680);

  /**
   * @var CDbConnection
   */
  private $rifDB;

  private $living = array();

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
   * @return void
   */
  protected function doExecute()
  {
    $hotel = Registry::GetRequestVar('hotel', 1);

    $sql = "SELECT u.RocId, pa.Value FROM Mod_PayOrderItem as oi
          INNER JOIN Mod_PayProduct as p ON oi.ProductId = p.ProductId
          INNER JOIN User as u ON oi.PayerId = u.UserId
          LEFT JOIN Mod_PayProductAttribute as pa ON p.ProductId = pa.ProductId
          WHERE (oi.Paid = 1) AND p.Manager = 'RoomProductManager' AND pa.Name = 'Hotel'";

    $result = Registry::GetDb()->createCommand($sql)->queryAll();

    foreach ($result as $user)
    {
      $this->living[$user['RocId']] = $user['Value'];
    }

    $command = $this->rifDB()->createCommand();
    $result = $command->select('*')->from('ext_living_users')->queryAll();

    foreach ($result as $user)
    {
      $owner = $user['owner'];
      $companion = $user['companion'];
      if (isset($this->living[$owner]) && !isset($this->living[$companion]))
      {
        $this->living[$companion] = $this->living[$owner];
      }
    }

    $sql = "SELECT u.RocId, p.ProductId FROM Mod_PayOrderItem as oi
              INNER JOIN Mod_PayProduct as p ON oi.ProductId = p.ProductId
              INNER JOIN User as u ON oi.OwnerId = u.UserId
              WHERE (oi.Paid = 1) AND p.Manager = 'FoodProductManager' AND p.EventId = :EventId
              ORDER BY u.RocId, p.ProductId";

    $command = Registry::GetDb()->createCommand($sql);
    $command->bindValue(':EventId', 245);

    $food = $command->queryAll();

    $output = '';
    $newLine = "\r\n";
    foreach ($food as $value)
    {
      $rocId = $value['RocId'];
      $productId = $value['ProductId'];
      if ($hotel == 1)
      {
        $output .= $this->checkHotel_1($rocId, $productId) ? $rocId . ';' . $productId . $newLine : '';
      }
      else
      {
        $output .= $this->checkHotel_2($rocId, $productId) ? $rocId . ';' . $productId . $newLine : '';
      }
    }

    echo $output;
  }

  private function checkHotel_1($rocId, $productId)
  {
    $notLiving = !isset($this->living[$rocId]);
    return $notLiving
      || $this->living[$rocId] == 'ЛЕСНЫЕ ДАЛИ'
      || ($this->living[$rocId] == 'НАЗАРЬЕВО' && !in_array($productId, $this->breakfast))
      || $productId == $this->furshetId;
  }

  private function checkHotel_2($rocId, $productId)
  {
    return $productId != $this->furshetId && isset($this->living[$rocId]) && $this->living[$rocId] == 'ПОЛЯНЫ';
  }
}
