<?php

AutoLoader::Import('library.mail.*');
AutoLoader::Import('library.rocid.pay.*');

class UtilityMailStatic extends AdminCommand
{
  const Step = 500;

  public static $MailName = 'idea12-1';

  /**
   * @var View
   */
  private $mail;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    set_time_limit(84600);
/*
    $criteria = new CDbCriteria();

    $userModel = User::model()->with(array('Emails', 'Settings' => array('select' => false, 'together' => true)));
    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId';
    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId);


//    $userModel = User::model()->with(array('Addresses.City.Region', 'Emails', 'Settings' => array('select' => false)))->together();
//    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND Region.RegionId = :RegionId';
//    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RegionId' => 4312);


//    $arUsers = file('user_list.csv');
//    $arUsers = array(515,595,1201,1726,2535,2718,2731,4809,9113,9206,10390,11943,12132,13029,13251,13583,13639,13806,14865,15088,15466,16182,16846,17595,18186,19625,19634,21002,24707,28660,29724,30544,32133,32632,32802,33117,33695,34182,34213,34457,34520,36832,37327,40007,44057,45610,49335,49691,50721,78284,80141,82259,96015,99992,101876,105736,108191,108249,111968,115151,115826,116080,116124,116286,116502);
//    $criteria->addInCondition('t.RocId', array(12953));
//    $criteria->addInCondition('t.RocId', $arUsers);

    echo $userModel->count($criteria);
    return;

    $users = $userModel->findAll($criteria);
*/

    
//    exit();
    
    
    
    /* Шаблон сообщений */
    $this->mail = new View();
    $this->mail->SetTemplate(self::$MailName, 'utility', 'static', 'mail');

    $fp = fopen(self::$MailName.'.log',"a+");

    $j=0;
    $users = file($_SERVER['DOCUMENT_ROOT'] . '/users.csv');
		$items = array_unique($users);
		print '<pre>';
		print_r($items);
		print '</pre>';
		exit();
//    $mails = array('v.eroshenko@gmail.com', 'chistov@raec.ru', 'kazaryan@raec.ru', 'grebennikov@raec.ru');
    foreach ($items as $item)
    {
    	list($lastname, $firstname, $email) = explode(';', $item);
			$this->mail->LastName = trim($lastname);
			$this->mail->FirstName = trim($firstname);
			$email = trim($email);
			$this->mail->Login = $email;
			$this->mail->Password = substr(md5($email.'idea'), 0, 6);
      $this->sendMail($email, false);
//      $this->sendMail($mail, false);

      if ($j == 200) { sleep(1); $j = 0; }; $j++;
//      fwrite($fp, "$user->RocId\n");
//      fwrite($fp, "$mail\n");
      fwrite($fp, "$email\n");
    }

//    fwrite($fp, "\n\n\n" . sizeof($users) . "\n\n\n");
//    fwrite($fp, "\n\n\n" . sizeof($mails) . "\n\n\n");
    fwrite($fp, "\n\n\n" . sizeof($items) . "\n\n\n");

    fclose($fp);
    
    echo 'All send!!!';

  }

  /**
   * @param User $user
   * @return void
   */
/*
  private function sendMail($user, $isHTML = true)
  {
    $this->mail->FirstName = $user->FirstName;
    $this->mail->FatherName = $user->FatherName;
    $this->mail->RocId = $user->RocId;
    
    
    
    
    $coupon = new Coupon();
    $coupon->EventId = 236;
    $coupon->Discount = '0.5';
    $coupon->ProductId = 3;
    $this->mail->Promo = $coupon->Code = $coupon->GenerateCode();
    $coupon->save();
    
    
    
    
    
    $mail = new PHPMailer(false);
    $mail->ParamOdq = true;
    $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
    $mail->IsHTML($isHTML);
    $email = !empty($user->Emails) ? $user->Emails[0]->Email : $user->Email;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      return;
    }
    $mail->AddAddress($email);
    $mail->SetFrom('info@in-numbers.ru', 'Журнал "Интернет в цифрах"', false);
    $mail->CharSet = 'utf-8';
    $mail->Subject = '=?UTF-8?B?'. base64_encode('Скидка подписчикам на участие в i-COMference 2012') .'?=';
    $mail->Body = $this->mail;
    //$mail->Send();
  }
*/

  /**
   * @param User $user
   * @param bool $isHTML
   * @return void
   */
  private function sendMail($email, $isHTML = true)
  {
/*
    $coupon = new Coupon();
    $coupon->EventId = 236;
    $coupon->Discount = '0.5';
    $coupon->ProductId = 3;
    $this->mail->Promo = $coupon->Code = $coupon->GenerateCode();
    $coupon->save();
*/
    $mail = new PHPMailer(false);
    $mail->ParamOdq = true;
    $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
    $mail->IsHTML($isHTML);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      return;
    }
    $mail->AddAddress($email);
    $mail->SetFrom('idea@premiaruneta.ru', 'Премия Рунета — Идея!', false);
    $mail->CharSet = 'utf-8';
    $mail->Subject = '=?UTF-8?B?'. base64_encode('Прими участие в формировании правил Народного Голосования') .'?=';
    $mail->Body = $this->mail;
		
//		$mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/site2012_invite.pdf');

//    $mail->Send();
  }
  
}
