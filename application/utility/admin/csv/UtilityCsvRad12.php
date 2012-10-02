<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 10/2/12
 * Time: 6:11 PM
 * To change this template use File | Settings | File Templates.
 */
class UtilityCsvRad12 extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    ini_set("memory_limit", "512M");

    $eventId = 312;

    $days = array(1, 2);

    foreach ($days as $dayId)
    {
      $file = fopen('rad12-'.$dayId.'_02102012.csv', 'w');

      $model = EventUser::model()->with(array('User', 'User.Settings', 'User.Employments' => array('on' => 'Employments.Primary = 1'), 'User.Employments.Company', 'User.Emails'));

      $criteria = new CDbCriteria();
      $criteria->condition = 't.EventId = :EventId AND t.DayId=:DayId';
      $criteria->params = array(':EventId' => $eventId, ':DayId' => $dayId);
      $criteria->group = 't.UserId';
      $criteria->order = 't.CreationTime';

      /** @var $eventUsers EventUser[] */
      $eventUsers = $model->findAll($criteria);

      foreach($eventUsers as $eUser)
      {
//        if ($eUser->RoleId == 24)
//        {
//          continue;
//        }
        /** @var $user User */
        $user = $eUser->User;

        $name = iconv('utf-8', 'Windows-1251', $user->LastName . ' ' . $user->FirstName . (!empty($user->FatherName) ? ' ' . $user->FatherName : ''));

        $lastName = iconv('utf-8', 'Windows-1251', $user->LastName);
        $firstName = iconv('utf-8', 'Windows-1251', $user->FirstName);

        $CompanyName = '';
        $Position = '';

        if (!empty($user->Employments))
        {
          $Position = iconv('utf-8', 'Windows-1251', $user->Employments[0]->Position);
          $CompanyName = iconv('utf-8', 'Windows-1251', $user->Employments[0]->Company->Name);
        }

        $roleName = iconv('utf-8', 'Windows-1251', $eUser->EventRole->Name);

//        $items = OrderItem::GetByOwnerAndEventId($eUser->UserId, $eUser->EventId);
//
//        $products = '';
//        foreach ($items as $item)
//        {
//          if ($item->Paid != 1)
//          {
//            continue;
//          }
//          $products .= iconv('utf-8', 'Windows-1251', $item->Product->Title) . ' ';
//        }

        //$email = iconv('utf-8', 'Windows-1251', $user->GetEmail() != null ? $user->GetEmail()->Email : $eUser->User->Email);

        //$sendMail = iconv('utf-8', 'Windows-1251', $user->Settings->ProjNews == 1 ? 'да' : 'нет');

        fputcsv($file, array($user->RocId, $lastName, $firstName, $CompanyName, $Position, $roleName), ';');
      }
      fclose($file);
    }



    echo 'Done!';
  }
}