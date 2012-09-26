<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 9/26/12
 * Time: 1:07 AM
 * To change this template use File | Settings | File Templates.
 */
class UtilityFillFast extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {

    return;
    $rocId = array(13946,14723,27097,32925,40242,54384,54966,88065,88267,100877,105447,105926,106933,108466,
      110769,    116188,    116392,    118281,    123433,    124516,    124916,    124917,    124918,    124919,    124920,    124921,    124922,    124923,    124924,
      124925,    124926,    124927,    124929,    124930,    124931,    124932,    124933);

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.RocId', $rocId);

    /** @var $users User[] */
    $users = User::model()->findAll($criteria);

    $event = Event::GetById(246);
    $role = EventRoles::GetById(12);

    foreach ($users as $user)
    {
      $eventUser = $event->RegisterUser($user, $role);
      if (empty($eventUser))
      {
        $eventUser = EventUser::GetByUserEventId($user->UserId, $event->EventId);
        $eventUser->UpdateRole($role);
      }

      echo $user->RocId . ' success<br>';
    }
  }
}
