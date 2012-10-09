<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 10/9/12
 * Time: 6:57 PM
 * To change this template use File | Settings | File Templates.
 */
class UtilityCsvResearch12 extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    ini_set("memory_limit", "512M");

    $file = fopen('research12_09102012.csv', 'w');
    $eventId = 368;

    $model = EventUser::model()->with(array('User', 'User.Settings', 'User.Employments' => array('on' => 'Employments.Primary = 1'), 'User.Employments.Company', 'User.Emails', 'User.Phones'));

    $criteria = new CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params = array(':EventId' => $eventId);
    $criteria->group = 't.UserId';
    $criteria->order = 't.CreationTime';

    /** @var $eventUsers EventUser[] */
    $eventUsers = $model->findAll($criteria);

    foreach($eventUsers as $eUser)
    {
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


      $phones = '';
      foreach ($eUser->User->Phones as $phone)
      {
        $phones .= iconv('utf-8', 'Windows-1251', $phone->Phone) . ' ';
      }

      $email = iconv('utf-8', 'Windows-1251', $user->GetEmail() != null ? $user->GetEmail()->Email : $eUser->User->Email);

      //$sendMail = iconv('utf-8', 'Windows-1251', $user->Settings->ProjNews == 1 ? 'да' : 'нет');

      fputcsv($file, array($user->RocId, $lastName, $firstName, $CompanyName, $Position, $roleName, $email, $phones), ';');

    }
    fclose($file);

    echo 'Done!';
  }
}
