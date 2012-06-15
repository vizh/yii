<?php

AutoLoader::Import('library.mail.*');

class UtilityMail extends AdminCommand
{
  const Step = 500;

  public static $MailName = 'spic-end-smi';
  public static $EventIdName = 'rif12';

  /**
   * @var View
   */
  private $mail;

  /**
   * Основные действия комманды
   * @param int $rocId
   * @return void
   */
  protected function doExecute($rocId = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);
    $rocId = intval($rocId);
    $criteria = new CDbCriteria();

    //все участники
    /*
    $userModel = User::model()->with(array('Emails', 'Settings' => array('select' => false, 'together' => true)));
    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId';
//    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId AND t.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId = :EventId)';
//    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId, ':EventId' => 245);
    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId);
    */
    

    // Жители региона, не зарегистрированные на конкретное мероприятие
  	/*
    $userModel = User::model()->with(array('EventUsers' => array('select' => false), 'Settings' => array('select' => false), 'Emails', 'Addresses.City' => array('select' => false)))->together();
//    t.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId = :EventId) AND
			$criteria->condition = 'City.RegionId IN (4052,4800,3827,3468,3282,1998532) AND Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId';

//    City.CountryId/RegionId/CityId
//    $criteria->condition = '(Addresses.CityId IS NULL OR City.RegionId != :RegionId) AND Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId AND t.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId = :EventId)';
    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId);
    */

    // [НЕ]Участники конкретного мероприятия
    
//    $userModel = User::model()->with(array('EventUsers' => array('select' => false, 'together' => true), 'Settings' => array('select' => false, 'together' => true), 'Emails'));
//    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId AND t.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId = :EventId)';
//    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId';
//    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId);
//    $criteria->addInCondition('EventUsers.EventId', array(245));

    //$criteria->condition = 't.RocId > :RocId';
    //$criteria->params = array(':RocId' => $rocId);
		


//    $userModel = $userModel->with(array('EventUsers' => array('select' => false, 'together' => true)));
//    $criteria->addInCondition('EventUsers.EventId', array(236));
//    $criteria->addInCondition('EventUsers.EventId', array(95,43,9,171,107,200,248,196));

    // Участники конкретного мероприятия + выборка по ролям
    $userModel = User::model()->with(array('Emails',
                                          'Settings' => array('select' => false, 'together' => true),
                                          'EventUsers' => array('together' => true)));

    //$criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId AND EventUsers.EventId = :EventId';
    //$criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId, ':EventId' => 200);

    $criteria->condition = 't.RocId > :RocId';
    $criteria->params = array(':RocId' => $rocId);


    //1
    $criteria->addInCondition('EventUsers.EventId', array(176, 258, 153, 236));
    $criteria->addInCondition('EventUsers.RoleId', array(2));

    //2
    // КРОМЕ виртуальные участники
//    $criteria->addNotInCondition('EventUsers.RoleId', array(24));

    //3
    //$criteria->addInCondition('EventUsers.RoleId', array(3, 5, 6, 22, 23, 25));


    //Все участники + участники с определенной ролью
//    $userModel = User::model()->with(array('Emails',
//                                          'Settings' => array('select' => false, 'together' => true),
//                                          'EventUsers' => array('together' => true, 'on' => 'EventUsers.EventId=:EventId', 'params' => array(':EventId'=>200))));
//
//    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId';
//    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId);



    //test
//    $arUsers = array(314,323,391,515,595,735,866,924,1150,1170,1186,1201,1395,1726,1752,1763,1995,2284,2486,2535,2570,2661,2718,2731,2735,4809,8894,9102,9113,9206,9548,9698,10390,10766,11324,11943,12132,13029,13251,13295,13494,13583,13639,13671,13761,13806,13950,14048,14250,14335,14444,14585,14865,14908,15014,15088,15466,16182,16493,16660,16846,17595,17602,17995,18031,18186,19154,19625,19634,19780,20459,20546,21002,22695,23779,24707,28660,29458,29724,29766,29917,30527,30544,30615,30949,31033,31098,31259,31996,32133,32632,32802,32904,33117,33396,33695,33697,33990,34182,34213,34457,34520,34759,36832,37064,37327,40007,40139,40717,42909,44057,45610,49335,49570,49691,49753,49760,50721,52799,52895,53456,54260,54453,54867,55247,78284,80141,80829,81563,81635,82259,82617,84052,84873,85557,85925,91535,92136,93535,93737,93847,94069,94119,95125,95906,96015,97711,100865,101573,101876,104880,105736,106920,107385,108191,108249,109267,111968,112087,112280,115151,115462,115826,115834,115899,116019,116080,116124,116286,116374,116494,116502,116678,116786,116867,117045,117066,117081,117193,117195,117212,117235,117274,117281,117293,117305,117361,117362,117376,117408);

    //$iResearch = array(35287, 454, 44330,1756,611,13295,13583,1523,2216,37497,9102,8891,14049,116357,8414,9174,106814,1362,9102,1707,15769,117281,44102,96974,106814,1362,115370,2019,8404,55620,1707,8894,13441,22575,13271,14635,14287,14249,1752,10768,1340,727,100635,1107,31337,13734,34175,96108,10418,33313,101133,31155,29931,54514,33313,15053,29873,51490,8894,15675,10513,29880,102402,29870,107259,13262,2346,515,29961,50891,104712,94610,1395,85396,116979,106849,55266,837,2441,44215,5469,868,663,733,13131,18242,97143,53517,101542,56303,28900,95347,83681,15132,396,30024,);

//    $iResearch2 = array( 35287, //454,
//      /*22636, 33313, 15769, 95983, 2216, 13873, 14048, 8105, 8414, 13441, 2019,*/
//      //51488,
//      33313
//    );

    
    //$criteria->addInCondition ('t.RocId', array(12953, 454, 35287));
    //$criteria->addInCondition ('t.RocId', $arUsers);
//    $criteria->addInCondition('t.RocId', array(35287, 337, 12959, 454, 12953, 77777, 38876, 18120));

//    $criteria->addInCondition ('t.RocId', $iResearch2);

    //$criteria->addInCondition('t.RocId', array(35287, 454));



    echo $userModel->count($criteria);
    return;


    /* Шаблон сообщений */
    $this->mail = new View();
    $this->mail->SetTemplate(self::$MailName, 'utility', 'templates', 'mail');

    $criteria->offset = 0;
    $criteria->limit = self::Step;
    $criteria->order = 't.RocId';
    //$criteria->group = 't.RocId';

    $fp = fopen(self::$MailName.'.log',"a+");

    //Заменять на соответствующую модель
    //$userModel = User::model()->with(array('Emails', 'Settings' => array('select' => false, 'together' => true)));
    $users = $userModel->findAll($criteria);
    
    $j=0;
    $lastRocId = 0;

    foreach ($users as $user)
    {
      $this->sendMail($user, false);
      $lastRocId = $user->RocId;
      

      if ($j == 300) { sleep(1); $j = 0; }; $j++;
      fwrite($fp, "$user->RocId\n");
    }

    fwrite($fp, "\n\n\n" . sizeof($users) . "\n\n\n");

    fclose($fp);


    if (empty($users))
    {
      echo 'All send!!!';
    }
    else
    {
      sleep(5);
      $url = RouteRegistry::GetAdminUrl('utility', '', 'mail', array('rocId' => $lastRocId));
      echo '<html><head><meta http-equiv="REFRESH" content="0; url='.$url.'"></head><body></body></html>';
    }
  }

  /**
   * @param User $user
   * @return void
   */
  private function sendMail($user, $isHTML = true)
  {
    $this->mail->EventName = self::$EventIdName;
    
    $this->mail->FirstName = $user->FirstName;
    $this->mail->FatherName = $user->FatherName;
    $this->mail->RocId = $user->RocId;
    
//    $this->mail->RoleName = $user->EventUsers[0]->EventRole->Name;

    //    if (!empty($user->EventUsers) && $user->EventUsers[0]->RoleId != 1)
    //    {
    //      return;
    //    }

    $this->mail->RegLink = $this->getRegLink($user);
    $this->mail->UnsubscribeLink = $this->getUnsubscribeLink($user);

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
    $mail->SetFrom('pr@sp-ic.ru', 'СПИК-2012', false);
    $mail->CharSet = 'utf-8';
    $mail->Subject = '=?UTF-8?B?'. base64_encode('Итоги и аналитика') .'?=';
    $mail->Body = $this->mail;

    //$mail->AddAttachment('spic-attach.docx', 'СПИК_итоги.docx');

    //$mail->Send();
    echo $this->mail;
  }
  
  /**
   * @param User $user
   * @return string
   */
  private function getRegLink($user)
  {
    $secret = 'gQVcymFs5NkY0jjNOxuRcfkKC';

    $timestamp = time();
    $rocid = $user->RocId;
    //$checkKey = substr(md5($rocid.$secret), 0, 16);

    $hash = substr(md5($rocid . $secret . $timestamp), 0, 8);

    return 'http://rocid.ru/i-research/approve/vote/' . $rocid . '/' . $timestamp . '/' . $hash . '/';

    //return 'http://2012.russianinternetforum.ru/my/?ROCID=' . $rocid . '&KEY=' . $checkKey;
//    return 'http://2012.russianinternetforum.ru/my/?ROCID=' . $rocid . '&KEY=' . $checkKey .'&FOODPAGE';

/*
    $email = !empty($user->Emails) ? $user->Emails[0]->Email : $user->Email;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      return;
    }
    return 'http://i-com.ru-golos.ru/reg/'. urlencode(base64_encode($email)) .'/'. md5($email.'i-com'.'_Salt') .'/';
*/
  }

  /**
   * @param User $user
   * @return string
   */
  private function getUnsubscribeLink($user)
  {
    $rocid = $user->RocId;
    $secret = 'qnpvoztjfuuavcfrzwadsmsjn';
    $hash = substr(md5($rocid.$secret), 0, 16);

    return RouteRegistry::GetUrl('user', 'edit', 'unsubscribe', array('rocid' => $rocid, 'hash' => $hash));
  }
}
