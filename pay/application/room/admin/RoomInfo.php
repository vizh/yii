<?php
AutoLoader::Import('library.rocid.pay.*');

class RoomInfo extends AdminCommand
{
  private static $Dates = array('2012-04-17', '2012-04-18', '2012-04-19');

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    ini_set("memory_limit", "512M");

    $criteria = new CDbCriteria();
    $criteria->condition = 't.Deleted = :Deleted AND Product.Manager = :Manager';
    $criteria->params = array(
      ':Deleted' => 0,
      ':Manager' => 'RoomProductManager'
    );




    $model = OrderItem::model()->with('Params', 'Product', 'Product.Attributes')->together();

    /** @var $items OrderItem[] */
    $items = $model->findAll($criteria);

    $result = array();
    foreach ($items as $item)
    {
      $hotel = $item->Product->GetAttribute('Hotel')->Value;
      if (! isset($result[$hotel]))
      {
        foreach (self::$Dates as $value)
        {
          $result[$hotel][$value] = array('Sale' => 0, 'Booked' => 0, 'PriceSale' => 0, 'PriceBooked' => 0);
        }
      }

      foreach (self::$Dates as $value)
      {
        if ($item->GetParam('DateIn')->Value <= $value && $value < $item->GetParam('DateOut')->Value)
        {
          if ($item->Paid != 0)
          {
            $result[$hotel][$value]['Sale'] += 1;
            $result[$hotel][$value]['PriceSale'] += intval($item->Product->GetAttribute('Price')->Value);
          }
          else
          {
            $result[$hotel][$value]['Booked'] += 1;
            $result[$hotel][$value]['PriceBooked'] += intval($item->Product->GetAttribute('Price')->Value);
          }
        }
      }
    }


    $sql = 'SELECT count(p.ProductId) cp, pa.Value FROM Mod_PayProduct p
      LEFT JOIN Mod_PayProductAttribute pa ON p.ProductId = pa.ProductId
      WHERE pa.Name = :Name GROUP BY pa.Value';

    $command = Registry::GetDb()->createCommand($sql);
    $command->bindValue(':Name', 'Hotel');

    $full = $command->queryAll();

    $this->view->Dates = self::$Dates;
    $this->view->Result = $result;
    $this->view->Full = $full;

    echo $this->view;
  }
}
