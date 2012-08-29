<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');


class UtilitySampleSite12 extends AdminCommand
{

  const Site11Date = '2011-09-15';
  const Site12Date = '2012-09-27';

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    ini_set("memory_limit", "512M");

    $SearchEvents = array(195, 246);

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.EventId', $SearchEvents);
    $criteria->group = 't.UserId';

    /** @var $eventUsers EventUser[] */
    $eventUsers = EventUser::model()->findAll($criteria);
    $idList = array();
    foreach ($eventUsers as $eUser)
    {
      $idList[] = $eUser->UserId;
    }

    $userModel = User::model();//->with(array('EventUsers', 'EventUsers.Event'));

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.UserId', $idList);
    $criteria->order = 't.RocId';

    /** @var $users User[] */
    $users = $userModel->findAll($criteria);


    $result = array();
    foreach ($users as $user)
    {
      $info = new stdClass();
      $info->RocId = $user->RocId;
      $info->FullName = $user->GetFullName();
      $info->Registration = date('Y-m-d', $user->CreationTime);
      $info->Site11 = false;
      $info->Site12 = false;
      $info->BeforeSite11 = false;
      $info->BeforeSite12 = false;
      $info->After = false;


      foreach ($user->EventUsers as $eUser)
      {
        if ($eUser->EventId == 195)
        {
          $info->Site11 = true;
        }
        if ($eUser->EventId == 246)
        {
          $info->Site12 = true;
        }
        if ($eUser->Event->DateStart < self::Site11Date
          && !in_array($eUser->EventId, $SearchEvents))
        {
          $info->BeforeSite11 = true;
        }
        if ($eUser->Event->DateStart > self::Site11Date &&
          $eUser->Event->DateStart < self::Site12Date &&
          !in_array($eUser->EventId, $SearchEvents))
        {
          $info->BeforeSite12 = true;
        }
        if ($eUser->Event->DateStart > self::Site12Date
          && !in_array($eUser->EventId, $SearchEvents))
        {
          $info->After = true;
        }
      }
      $result[] = $info;
    }
    $this->printResult($result);

    echo 'done!';
  }

  private function printResult($result)
  {
//    echo '<table>';
//    echo '<tr>';
//    echo '<td>RocId</td>';
//    echo '<td>Полное имя</td>';
//    echo '<td>Дата регистрации в rocID</td>';
//    echo '<td>Участие в Site11</td>';
//    echo '<td>Участие в Site12</td>';
//    echo '<td>Участие в мероприятиях до Site11</td>';
//    echo '<td>Участие в мероприятиях между Site11 и Site12</td>';
//    echo '<td>Участие в мероприятиях после Site12</td>';
//    echo '</tr>';

    $fp = fopen('siteuserinfo.csv', 'w');
    fputcsv($fp, array('RocId', 'Полное имя', 'Дата регистрации в rocID', 'Участие в Site11', 'Участие в Site12', 'Участие в мероприятиях до Site11', 'Участие в мероприятиях между Site11 и Site12', 'Участие в мероприятиях после Site12'));

    foreach ($result as $info) {
        fputcsv($fp, (array)$info);
    }

    fclose($fp);

//    foreach ($result as $info)
//    {
//      echo '<tr>';
//      echo '<td>' . $info->RocId . '</td>';
//      echo '<td>' . $info->FullName . '</td>';
//      echo '<td>' . $info->Registration . '</td>';
//      echo '<td>' . ($info->Site11 ? 'да' : 'нет') . '</td>';
//      echo '<td>' . ($info->Site12 ? 'да' : 'нет') . '</td>';
//      echo '<td>' . ($info->BeforeSite11 ? 'да' : 'нет') . '</td>';
//      echo '<td>' . ($info->BeforeSite12 ? 'да' : 'нет') . '</td>';
//      echo '<td>' . ($info->After ? 'да' : 'нет') . '</td>';
//      echo '</tr>';
//    }
//    echo '</table>';
  }
}