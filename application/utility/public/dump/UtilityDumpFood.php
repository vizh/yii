<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');

class UtilityDumpFood extends AbstractCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $produvtId = 689;

    $criteria = new CDbCriteria();
    $criteria->condition = 't.ProductId = :ProductId AND t.Paid = :Paid';
    $criteria->params = array(':ProductId' => $produvtId, ':Paid' => 1);
    $orderItems = OrderItem::model()->with('Owner')->findAll($criteria);

    $output = '';
        $newLine = "\r\n";
    foreach($orderItems as $item)
    {
      $output .=  $item->Owner->RocId . ';' . $produvtId . $newLine;
    }

    echo $output;
  }
}
