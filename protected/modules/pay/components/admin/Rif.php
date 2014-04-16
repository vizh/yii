<?php
namespace pay\components\admin;

class Rif
{
  const HOTEL_LD = 'ЛЕСНЫЕ ДАЛИ';
  const HOTEL_P = 'ПОЛЯНЫ';
  const HOTEL_N = 'НАЗАРЬЕВО';
  const HOTEL_S = 'СОСНЫ';

  const EventId = 789;


  private static $db = null;

  /**
   * @return \CDbConnection
   */
  public static function getDb()
  {
    if (self::$db == null)
    {
      self::$db = new \CDbConnection('mysql:host=109.234.156.202;dbname=rif2014', 'rif2014', 'eipahgoo9PeetieN');
    }
    return self::$db;
  }


  private static function prepareUsers()
  {
    $nextUpdate = \Yii::app()->getCache()->get('NextRifPersonsUpdate');
    if ($nextUpdate != null && $nextUpdate > time())
      return;
    \Yii::app()->getCache()->set('NextRifPersonsUpdate', time()+15*60);

    $cmd = \pay\components\admin\Rif::getDb()->createCommand();
    $cmd->select('*')->from('ext_booked_person_together')->where('userRunetId IS NULL');
    $result = $cmd->queryAll();
    foreach ($result as $row)
    {
      $row['userName'] = trim($row['userName']);
      $user = \user\models\User::model()
        ->byEventId(self::EventId)->bySearch($row['userName'])->find();
      if ($user == null)
      {
        $parts = explode(' ', $row['userName']);
        if (count($parts) == 3)
        {
          $user = \user\models\User::model()
            ->byEventId(self::EventId)->bySearch($parts[0] . ' ' . $parts[1])->find();
        }
      }

      if ($user != null)
      {
        \pay\components\admin\Rif::getDb()->createCommand()->update('ext_booked_person_together', ['userRunetId' => $user->RunetId], 'id = :id', ['id' => $row['id']]);
      }
    }
  }

  private static $usersByHotel = null;

  public static function getUsersByHotel()
  {

    if (self::$usersByHotel == null)
    {
      self::prepareUsers();

      $criteria = new \CDbCriteria();
      $criteria->with = ['Product' => ['together' => true]];
      $criteria->addCondition('"Product"."ManagerName" = :ManagerName');
      $criteria->params = ['ManagerName' => 'RoomProductManager'];
      $criteria->order = 't."PaidTime"';
      $roomItems = \pay\models\OrderItem::model()
        ->byEventId(self::EventId)->byPaid(true)->findAll($criteria);

      $cmd = \pay\components\admin\Rif::getDb()->createCommand();
      $cmd->select('*')->from('ext_booked_person_together')->where('userRunetId IS NOT NULL');
      $result = $cmd->queryAll();

      $usersTogether = [];
      foreach ($result as $row)
      {
        $usersTogether[$row['ownerRunetId']][] = $row['userRunetId'];
      }

      self::$usersByHotel = [];
      $owners = [];
      foreach ($roomItems as $item)
      {
        $owner = $item->ChangedOwnerId != null ? $item->ChangedOwner : $item->Owner;
        self::$usersByHotel[$item->Product->getManager()->Hotel][] = $owner->RunetId;
        $owners[] = $owner->RunetId;
      }

      foreach ($roomItems as $item)
      {
        $owner = $item->ChangedOwnerId != null ? $item->ChangedOwner : $item->Owner;
        if (empty($usersTogether[$owner->RunetId]))
          continue;
        foreach ($usersTogether[$owner->RunetId] as $runetId)
        {
          if (in_array($runetId, $owners))
            continue;

          self::$usersByHotel[$item->Product->getManager()->Hotel][] = $runetId;
          $owners[] = $runetId;
        }
      }
    }

    return self::$usersByHotel;
  }

  /**
   * @param int $runetId
   * @return null|string
   */
  public static function getUserHotel($runetId)
  {
    $users = self::getUsersByHotel();
    foreach ($users as $key => $values)
    {
      if (in_array($runetId, $values))
        return $key;
    }
    return null;
  }
} 