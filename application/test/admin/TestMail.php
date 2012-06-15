<?php

AutoLoader::Import('library.mail.*');

class TestMail extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    set_time_limit(0);
    
    $userModel = User::model()->with(array('EventUsers' => array('select' => false), 'Settings' => array('select' => false), 'Emails', 'Addresses.City' => array('select' => false)))->together();
    
    $criteria = new CDbCriteria();
    
    // Жители региона, не зарегистрированные на конкретное мероприятие
//    $criteria->condition = 't.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId = :EventId) AND City.RegionId = :RegionId AND Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews';
//    $criteria->params = array(':EventId' => 196, ':RegionId' => 4925, ':Visible' => '1', ':ProjNews' => '1');
    
    // Участники конкретного мероприятия
    //$criteria->condition = 'EventUsers.EventId = :EventId AND Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews';
    //$criteria->params = array(':EventId' => 196, ':Visible' => '1', ':ProjNews' => '1');

    // Тест
    //$criteria->addInCondition('t.RocId', array(454,35287));
    
    $criteria->offset = 0;
    $criteria->limit = 2000;
    
	/* Шаблон сообщений */
	$view = new View();
    $view->SetTemplate('mail-ismi11-lenreg');
    
    $users = $userModel->findAll($criteria);
    print count($users) . '<br>'; //exit;
    
    $i = 0;
	$fp = fopen('mail-ismi11-regusers.log',"w");
	
    foreach ($users as $user)
    {
    	$view->LastName = $user->LastName;
    	$view->FirstName = $user->FirstName;
    	//$view->RegLink = 'http://riw2011.ru/my/'. $user->RocId .'/'. substr(md5($user->RocId . 'vyeavbdanfivabfdeypwgruqe'), 0, 16) .'/';
    	
//	    $mail = new PHPMailer(false);
//	    $mail->ContentType = 'text/plain';
//	    $mail->IsHTML(false);
//	    $mail->AddAddress(!empty($user->Emails) ? $user->Emails[0]->Email : $user->Email);
//	    $mail->SetFrom('info@rocid.ru', 'rocID:// Календарь', false);
//	    $mail->CharSet = 'utf-8';
//	    $mail->Subject = '=?UTF-8?B?'. base64_encode('Докладчикам международной конференции «СМИ и социальные сети: перспективы взаимодействия»') .'?=';
//    	$mail->Body = $view;
    	//$mail->Send();
    	
    	//fwrite($fp, "$user->RocId\n");
      echo $user->RocId . '<br>';
    	
    	//if ($i == 200) { sleep(3); $i = 0; }; $i++;
    }
  }
  
}
