<?php
AutoLoader::Import('library.rocid.pay.*');

class SystemBookedClear extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $count = OrderItem::ClearBooked();
    echo 'clear:' . $count . "\r\n";
  }
}
