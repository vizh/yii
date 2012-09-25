<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('utility.source.*');

class UtilityFillSite12 extends AdminCommand
{

  const Path = '/files/';
  const FileName = 'new_event246-all-allROCID.csv';
  const EventId = 246;


  private $products = array();
  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    return;

    $fieldMap = array(
      'Company' => 0,
      'FIO' => 1,
      'RocId' => 2,

      'Role' => 3,
      'SubRole' => 4,


      'Email' => 5,

      'Phone' => 6,


    );

    $this->products[] = Product::GetById(693);
    $this->products[] = Product::GetById(698);
    $this->products[] = Product::GetById(699);

    $parser = new CsvParser($_SERVER['DOCUMENT_ROOT'] . self::Path . self::FileName);
    //$parser->UseRuLocale();
    $parser->SetInEncoding('utf-8');

    $results = $parser->Parse($fieldMap, true);

    $event = Event::GetById(246);

    foreach ($results as $info)
    {
      if (empty($info->RocId))
      {
        continue;
      }
      $user = User::GetByRocid($info->RocId);
      if (empty($user))
      {
        echo 'not found rocID:' . $info->RocId .'<br>';
        continue;
      }

      echo 'process user: '.$user->RocId.'<br>';
      $info->Role = trim($info->Role);
      $role = $this->getRole($info->Role);
      if ($role === null)
      {
        echo 'error with rocID:' . $info->RocId .'<br>';
        continue;
      }

      $eventUser = $event->RegisterUser($user, $role);
      if (empty($eventUser))
      {
        $eventUser = EventUser::GetByUserEventId($user->UserId, $event->EventId);
        $eventUser->UpdateRole($role);
      }

      $orderItems = OrderItem::GetByOwnerAndEventId($user->UserId, $event->EventId);

      $product = $this->getProduct($info->SubRole);
      if ($product == null)
      {
        echo 'empty product for rocID:' . $info->RocId .'<br>';
        continue;
      }

      foreach ($orderItems as $orderItem)
      {
        if ($orderItem->ProductId == $product->ProductId)
        {
          if ($orderItem->Paid == 0)
          {
            $orderItem->Paid = 1;
            $orderItem->PaidTime = '2012-09-26 05:00:00';
            $orderItem->save();
          }
          continue;
        }
      }

      $orderItem = new OrderItem();
      $orderItem->ProductId = $product->ProductId;
      $orderItem->PayerId = $user->UserId;
      $orderItem->OwnerId = $user->UserId;
      $orderItem->Paid = 1;
      $orderItem->PaidTime = '2012-09-26 05:00:00';
      $orderItem->save();
    }
  }

  private function getRole($roleName)
  {
    $roleId = 0;
    if ($roleName == 'Участник')
    {
      $roleId = 1;
    }
    elseif ($roleName == 'Выставка')
    {
      $roleId = 12;
    }
    elseif ($roleName == 'Партнер')
    {
      $roleId = 5;
    }
    elseif ($roleName == 'Докладчик')
    {
      $roleId = 3;
    }
    return EventRoles::GetById($roleId);
  }

  /**
   * @param $productName
   * @return Product|null
   */
  private function getProduct($productName)
  {
    if ($productName == 'Рег взнос')
    {
      return $this->products[0];
    }
    elseif ($productName == 'пакет 1')
    {
      return $this->products[1];
    }
    elseif ($productName == 'пакет 2')
    {
      return $this->products[2];
    }

    return null;
  }
}
