<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 10/9/12
 * Time: 6:57 PM
 * To change this template use File | Settings | File Templates.
 */
class UtilityCsvParticipants extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    ini_set("memory_limit", "1024M");
    
    $eventId = Registry::GetRequestVar('eventId', null);
    $roleId = Registry::GetRequestVar('roleId', null);
    $withContact = Registry::GetRequestVar('withContact', 0);
    
    
    $criteria = new CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params = array(':EventId' => $eventId);
    $with = array(
      'EventRole',
      'User',
      'User.Settings',
      'User.Employments' => array('on' => 'Employments.Primary = 1'),
      'User.Employments.Company'
    );
    if ($withContact == 1)
    {
      $with[] = 'User.Emails';
      $with[] = 'User.Phones';
    }
    $criteria->with = $with;
    
    if ($roleId !== null)
    {
      $criteria->addCondition('t.RoleId = :RoleId');
      $criteria->params['RoleId'] = $roleId;
    }
    
    $criteria->group = 't.UserId';
    $criteria->order = 't.CreationTime';

    /** @var $eventUsers EventUser[] */
    $eventUsers = EventUser::model()->findAll($criteria);
    
    $file = fopen('event'.$eventId.'_'.date('dmY').'.csv', 'w');
    foreach($eventUsers as $eventUser)
    {
      $csvFields = array('rocId' => '', 'lastName' => '', 'firstName' => '', 'position' => '', 'companyName' => '', 'roleName' => '', 'phones' => '', 'email' => '');
      
      /** @var $user User */
      $user = $eventUser->User;
      
      $csvFields['rocId'] = $user->RocId;
      $csvFields['lastName']  = iconv('utf-8', 'Windows-1251', $user->LastName);
      $csvFields['firstName'] = iconv('utf-8', 'Windows-1251', $user->FirstName);
      
      if (!empty($user->Employments))
      {        
        $csvFields['position'] = !empty($user->Employments[0]->Position) ? iconv('utf-8', 'Windows-1251', $user->Employments[0]->Position) : '';
        $csvFields['companyName'] = iconv('utf-8', 'Windows-1251', $user->Employments[0]->Company->Name);
      }

      $csvFields['roleName'] = iconv('utf-8', 'Windows-1251', $eventUser->EventRole->Name);

      if ($withContact == 1)
      {
        if (!empty($eUser->User->Phones))
        {
          foreach ($eUser->User->Phones as $phone)
          {
            $csvFields['phones'] .= iconv('utf-8', 'Windows-1251', $phone->Phone) . ' ';
          }
        }
        $csvFields['email'] = iconv('utf-8', 'Windows-1251', $user->GetEmail() != null ? $user->GetEmail()->Email : $eUser->User->Email);
      }
      fputcsv($file, $csvFields, ';');
    }
    fclose($file);

    echo 'Done!';
  }
}
