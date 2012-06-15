<?php
AutoLoader::Import('library.rocid.pay.*');

class FoodInfo extends AdminCommand
{
  const ld = 'ЛЕСНЫЕ ДАЛИ';
  const p = 'ПОЛЯНЫ';
  const n = 'НАЗАРЬЕВО';
  const z = 'НИГДЕ НЕ ЖИВУТ';

  protected $living = array();
  protected $result = array();

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
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

    //echo sizeof($this->living) . '<br>';

    $sql = "SELECT * FROM Tmp_RoomCompanion";

    $result = Registry::GetDb()->createCommand($sql)->queryAll();

    foreach ($result as $user)
    {
      $owner = $user['Owner'];
      $companion = $user['Companion'];
      if (isset($this->living[$owner]) && !isset($this->living[$companion]))
      {
        $this->living[$companion] = $this->living[$owner];
      }
    }

    //echo sizeof($this->living) . '<br>';



    $breakfast = array(674, 677, 680);
    $lunch = array(675, 678, 681);
    $dinner = array(673, 679);
    $furshet = array(676);

    //завтраки
    $this->fillFoodInfo(674, array(self::ld => self::ld, self::p => self::p, self::n => self::n));
    $this->fillFoodInfo(677, array(self::ld => self::ld, self::p => self::p, self::n => self::n));
    $this->fillFoodInfo(680, array(self::ld => self::ld, self::p => self::p, self::n => self::n));
    //обеды
    $this->fillFoodInfo(675, array(self::ld => self::ld, self::p => self::p, self::n => self::ld));
    $this->fillFoodInfo(678, array(self::ld => self::ld, self::p => self::p, self::n => self::ld));
    $this->fillFoodInfo(681, array(self::ld => self::ld, self::p => self::p, self::n => self::ld));
    //ужины
    $this->fillFoodInfo(673, array(self::ld => self::ld, self::p => self::p, self::n => self::ld));
    $this->fillFoodInfo(679, array(self::ld => self::ld, self::p => self::p, self::n => self::ld));
    //фуршет
    $this->fillFoodInfo(676, array(self::ld => self::ld, self::p => self::ld, self::n => self::ld));

    foreach ($this->result as $key => $value)
    {
      $product = Product::GetById($key);

      echo "<h3>{$product->Title}</h3>";
      echo self::ld . ' : ' . $value[self::ld] . '<br>';
      echo self::p . ' : ' . $value[self::p] . '<br>';
      echo self::n . ' : ' . $value[self::n] . '<br>';
      echo self::z . ' : ' . $value[self::z] . '<br>';
    }


    //print_r($this->result);

  }

  private function fillFoodInfo($productId, $connect)
  {
    $this->result[$productId] = array(self::ld => 0, self::p => 0, self::n => 0, self::z => 0);
    $criteria = new CDbCriteria();
    $criteria->condition = 't.ProductId = :ProductId AND t.Paid = :Paid';
    $criteria->params = array(':ProductId' => $productId, ':Paid' => 1);

    /** @var $items OrderItem[] */
    $items = OrderItem::model()->with('Payer', 'Product')->findAll($criteria);
    foreach ($items as $item)
    {
      $rocId = $item->Payer->RocId;
      //$place = isset($this->living[$rocId]) ? $connect[$this->living[$rocId]] : self::ld;
      $place = isset($this->living[$rocId]) ? $this->living[$rocId] : self::z;
//      if (!isset($this->result[$productId][$place]))
//      {
//        $this->result[$productId][$place] = 0;
//      }
      $this->result[$productId][$place]++;
    }
  }

}