<?php
  class UtilityParticipants extends AdminCommand 
  {
    protected function doExecute($eventId = 0, $roleId = 0) 
    {
      ini_set("memory_limit", "512M");
      // Участники программы мероприятия
      /*
      $model = User::model()->with(array('EventProgramUserLink', 'Emails', 'Employments', 'Employments.Company'));
      $criteria = new CDbCriteria();
      $criteria->condition = 'EventProgramUserLink.EventId = :EventId';
      $criteria->params = array(':EventId' => $eventId);
      $criteria->order = 't.RocId';
      */

      // Участники мероприятия с определённой ролью
/*
      $model = EventUser::model()->with(array('User', 'User.Emails', 'User.Employments', 'User.Employments.Company'));
      $criteria = new CDbCriteria();
      $criteria->condition = 't.EventId = :EventId';
//      $criteria->condition = 't.EventId = :EventId AND t.RoleId = :RoleId';
      $criteria->params = array(':EventId' => $eventId);
      $criteria->order = 'User.RocId';
*/

      // Участники мероприятия с определённой ролью и телефоном
      $model = EventUser::model()->with(array('User', 'User.Phones', 'User.Emails', 'User.Employments', 'User.Employments.Company'))->together();
      $criteria = new CDbCriteria();
      $criteria->condition = 't.EventId = :EventId AND t.RoleId = :RoleId';
//      $criteria->condition = 't.EventId = :EventId AND Phones.PhoneId IS NOT NULL AND t.RoleId = :RoleId';
      $criteria->params = array(':EventId' => $eventId, ':RoleId' => $roleId);
      $criteria->order = 'User.RocId';
//      echo $model->count($criteria);
//      return;
      
      $fp = fopen ('participants_'.$eventId.'_'.date("Y.m.d_H.i.s").'.csv', "w");
      fputs($fp, "rocID;ФАМИЛИЯ;ИМЯ;ОТЧЕСТВО;КОМПАНИЯ;ДОЛЖНОСТЬ;E-MAIL;ТЕЛЕФОН\r\n");
      
      $eventUsers = $model->findAll($criteria);
      
      foreach($eventUsers as $eUser)
      {
/*
        $RocId = $eUser->RocId;
        $LastName = $eUser->LastName;
        $FirstName = $eUser->FirstName;
        $FatherName = $eUser->FatherName;

        $CompanyName = '';
        foreach($eUser->Employments as $employment)
        {
         if ($employment->Primary == 1)
         {
           if(isset($employment->Company))
           {
             $CompanyName = $employment->Company->Name;
             $Position = $employment->Position;
           }
           break;
         }
        }
        $CompanyName = str_replace(';', ',', $CompanyName);
        fputs($fp, "{$RocId};{$LastName};{$FirstName};{$FatherName};{$CompanyName}\r\n");
*/
				if (empty($eUser->User)) continue;

        $RocId = $eUser->User->RocId;
        $LastName = $eUser->User->LastName;
        $FirstName = $eUser->User->FirstName;
        $FatherName = $eUser->User->FatherName;

        $CompanyName = '';
        $Position = '';

        foreach($eUser->User->Employments as $employment)
        {
         if ($employment->Primary == 1)
         {
           if(isset($employment->Company))
           {
             $CompanyName = $employment->Company->Name;
             $Position = $employment->Position;
           }
           break;
         }
        }

        $Email = '';
        foreach($eUser->User->Emails as $email)
        {
          $Email .= ' / '. urldecode(urldecode($email->Email));
        }

        $Phone = '';
        foreach($eUser->User->Phones as $phone)
        {
          $Phone .= ' / '. urldecode(urldecode($phone->Phone));
        }

//        echo ("{$RocId};{$LastName};{$FirstName};{$FatherName};{$Email};{$Phone}<br />");
				$CompanyName = str_replace(';', ',', $CompanyName);
        fputs($fp, "{$RocId};{$LastName};{$FirstName};{$FatherName};{$CompanyName};{$Position};{$Email};{$Phone}\r\n");

      }
      fclose($fp);

      echo 'Готово!';
      
    }
  }
?>
