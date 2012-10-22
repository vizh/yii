<?php
AutoLoader::Import('library.rocid.pay.*');

class UtilityFillHl12 extends AdminCommand
{

  const ProuctId = 720;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    return;
    /** @var $eventUsers EventUser[] */
    $eventUsers = EventUser::model()->findAll('t.EventId = 385');

    foreach ($eventUsers as $eUser)
    {
      if (!in_array($eUser->RoleId, array(2, 6, 34)))
      {
        $item = new OrderItem();
        $item->ProductId = self::ProuctId;
        $item->PayerId = $eUser->UserId;
        $item->OwnerId = $eUser->UserId;
        $item->Paid = 1;
        $item->PaidTime = date('Y-m-d H:i:s');
        $item->CreationTime = date('Y-m-d H:i:s');
        //$item->save();
      }
    }
  }
}
