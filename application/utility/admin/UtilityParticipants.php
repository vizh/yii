<?php

class UtilityParticipants extends AdminCommand
 {
   protected function doExecute($eventId = 0, $roleId = 0)
   {
     $model = EventUser::model()->with(array('User', 'User.Emails', 'User.Employments', 'User.Employments.Company'));
     $criteria = new CDbCriteria();
     $criteria->condition = 't.EventId = :EventId';
     $criteria->params = array(':EventId' => $eventId);

     $eventUsers = $model->findAll($criteria);

     foreach($eventUsers as $eUser)
     {
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
       echo $RocId . ' ' . $LastName . ' ' . $FirstName . ' ' . $CompanyName . ' ' . $Position . ' <br />';
     }
   }
 }
