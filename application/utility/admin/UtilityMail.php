<?php

AutoLoader::Import('library.mail.*');
AutoLoader::Import('comission.source.*');


class UtilityMail extends AdminCommand
{
  const Step = 500;

  public static $MailName = 'i-research-4';
  public static $EventIdName = 'spic12';

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

    //ЭКСПЕРТЫ ВСЕХ КОМИССИЙ РАЭК           
    /*
    $criteria->with = array('User');
    $criteria->condition = 't.RoleId = 5';
    $commissionUsers = ComissionUser::model()->findAll($criteria);
    foreach ($commissionUsers as $commissionUser)
    {
			$rocids[] = $commissionUser->User->RocId;
    }
    $criteria = new CDbCriteria();
    */
    
    //ВСЕ УЧАСТНИКИ
    /*
    $userModel = User::model()->with(array('Emails', 'Settings' => array('select' => false, 'together' => true)));
    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId';
//    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId AND t.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId = :EventId)';
//    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId, ':EventId' => 245);
    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId);
    */
    
/*    
    $userModel = User::model()->with(array('Employments' => array('on' => 'Employments.Primary = 1'), 'Employments.Company', 'Emails', 'Settings' => array('select' => false, 'together' => true)));
    $criteria->condition = 't.RocId > :RocId';
    $criteria->params = array(':RocId' => $rocId);
*/

    // ЖИТЕЛИ РЕГИОНА, НЕ ЗАРЕГИСТРИРОВАННЫЕ НА КОНКРЕТНОЕ МЕРОПРИЯТИЕ
    /*
    $userModel = User::model()->with(array('EventUsers' => array('select' => false), 'Settings' => array('select' => false), 'Emails', 'Addresses.City' => array('select' => false)))->together();
//    t.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId = :EventId) AND
			$criteria->condition = 'City.RegionId IN (4312) AND Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId';

//    City.CountryId/RegionId/CityId
//    $criteria->condition = '(Addresses.CityId IS NULL OR City.RegionId != :RegionId) AND Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId AND t.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId = :EventId)';
    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId);
		*/
		
    // [НЕ]УЧАСТНИКИ КОНКРЕТНОГО МЕРОПРИЯТИЯ
    /*
    $userModel = User::model()->with(array('EventUsers' => array('select' => false, 'together' => true), 'Settings' => array('select' => false, 'together' => true), 'Emails'));
//    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId AND t.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId = :EventId)';
    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId';
//    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId);
//    $criteria->addInCondition('EventUsers.EventId', array(245));

    //$criteria->condition = 't.RocId > :RocId';
    //$criteria->params = array(':RocId' => $rocId);
		*/


    /*** i-research block **/

    /** @var $results VoteResult[] */
    $results = VoteResult::model()->findAll('t.VoteId = :VoteId', array(':VoteId' => 2));
    $usersId = array();
    foreach ($results as $result)
    {
      $info = $result->GetVoterInfo();
      $usersId[] = $info['UserId'];
    }
    /*** конец блока  ***/


		
    // УЧАСТНИКИ КОНКРЕТНОГО МЕРОПРИЯТИЯ + ВЫБОРКА ПО РОЛЯМ
    $userModel = User::model()->with(array('Emails',
      'Settings' => array('select' => false, 'together' => true),
      'EventUsers' => array('together' => true)));
//    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId AND t.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId IN (193,84,192))';
//    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId AND EventUsers.EventId = 246 AND EventUsers.RoleId = 24';
    $criteria->condition = 'Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews AND t.RocId > :RocId';
    $criteria->params = array(':Visible' => '1', ':ProjNews' => '1', ':RocId' => $rocId);
    $criteria->addInCondition('EventUsers.EventId', array(245, 217, 171, 176, 139, 200, 236, 153));
    //$criteria->addNotInCondition('User.UserId', $usersId);
//    $criteria->addInCondition('EventUsers.RoleId', array(24));

    //2
    // КРОМЕ ВИРТУАЛЬНЫЕ УЧАСТНИКИ
//    $criteria->addNotInCondition('EventUsers.RoleId', array(24));

    //3
    //$criteria->addInCondition('EventUsers.RoleId', array(3, 5, 6, 22, 23, 25));

    //$iResearch = array(35287, 454, 44330,1756,611,13295,13583,1523,2216,37497,9102,8891,14049,116357,8414,9174,106814,1362,9102,1707,15769,117281,44102,96974,106814,1362,115370,2019,8404,55620,1707,8894,13441,22575,13271,14635,14287,14249,1752,10768,1340,727,100635,1107,31337,13734,34175,96108,10418,33313,101133,31155,29931,54514,33313,15053,29873,51490,8894,15675,10513,29880,102402,29870,107259,13262,2346,515,29961,50891,104712,94610,1395,85396,116979,106849,55266,837,2441,44215,5469,868,663,733,13131,18242,97143,53517,101542,56303,28900,95347,83681,15132,396,30024,);

//    $iResearch2 = array( 35287, //454,
//      /*22636, 33313, 15769, 95983, 2216, 13873, 14048, 8105, 8414, 13441, 2019,*/
//      //51488,
//      33313
//    );

    //$iResearch3 = array(15055, 1186, 4884, 13761, 1763, 2216, 51080, 1752, 2346, 17995, 5469, 15712, 14249, 10418, 9174, 611, 8110, 13441, 15053, 14049, 49844, 13463, 372, 879, 55266, 81628, 13583, 8894, 663, 15456, 18054, 96253, 29106, 21894, 1523, 44330, 11409, 33313, 1756, 22662, 924, 733, 12959, 337, 862, 15466, 323, 33695, 8958, 868, 50723, 7325, 12676, 82748, 12132, 15404, 14594, 56303, 9700, 36955, 15154, 29873, 16228, 29663, 115015, 96988, 32133, 51003, 13851, 115151, 55779, 30018, 109267, 50090, 2508, 1465, 9433, 112087, 50181, 99779, 21930, 1726, 93847, 28418, 13251, 595, 29188, 48571, 93547, 45455, 97711, 15675, 2728, 12314, 101573, 13494, 1108, 1107, 30743, 2718, 427, 94862, 11241, 115864, 115877, 29909, 36832, 115899, 14865, 19154, 31033, 20475, 85192, 52799, 84171, 2735, 99070, 17941, 1527, 436, 3415, 515, 19606, 33697, 81308, 14447, 40074, 29878, 11324, 14335, 92138, 1320, 40717, 106934, 111968, 21002, 104365, 113798, 85396, 50721, 15014, 102560, 35136, 19993, 37327, 9113, 2337, 49570, 14908, 95895, 95066, 96175, 1827, 30589, 116127, 37180, 42622, 17527, 115834, 5553, 14048, 13671, 30926, 37244, 50947, 34213, 34251, 111283, 37064, 30116, 101629, 52720, 13100, 1222, 676, 96337, 17206, 55054, 1201, 36998, 100544, 82259, 52895, 30621, 13876, 575, 13916, 18242, 49714, 84001, 29922, 54759, 14444, 100380, 20459, 6421, 91394, 16846, 92910, 116366, 97143, 49335, 15088, 115249, 115418, 29174, 90922, 29836, 116439, 382, 37297, 105937, 2721, 116509, 527, 29880, 34502, 40139, 10390, 101876, 34430, 116540, 104880, 84873, 96936, 54867, 35587, 86757, 56083, 29670, 96504, 29984, 102807, 44781, 55511, 84138, 7312, 111315, 97422, 116678, 1395, 34520, 108655, 9103, 86646, 28228, 106025, 53680, 93534, 43926, 49932, 91535, 19160, 115462, 106982, 49089, 113680, 54453, 81722, 90923, 14287, 116862, 116863, 116867, 97773, 116906, 116786, 33396, 113995, 81563, 84091, 16493, 80829, 17024, 116759, 53456, 2404, 1311, 82563, 50702, 107201, 106603, 30330, 51088, 8891, 15606, 32982, 4180, 45848, 52777, 93535, 33573, 107648, 117045, 13950, 106376, 23856, 113884, 117066, 109204, 85752, 2570, 105029, 107766, 96582, 117081, 45227, 117088, 29458, 49753, 20546, 116998, 115038, 116826, 16344, 100865, 14250, 105990, 97446, 96854, 106385, 9698, 97683, 29917, 49796, 17907, 13062, 31996, 98300, 117195, 54199, 97308, 116560, 53546, 97444, 117218, 85418, 2574, 31259, 12795, 117247, 98808, 95906, 106849, 117281, 97532, 35155, 54556, 49760, 93621, 3768, 866, 9548, 117362, 93737, 117376, 13931, 94026, 30095, 106920, 9102, 22684, 13898, 86190, 105684, 86684, 17697, 28105, 41363, 110702, 117557, 86283, 35565, 85151, 18357, 29662, 117762, 117792, 115361, 35816, 117813, 10434, 117725, 50562, 117618, 35079, 14649, 14220, 96334, 32622, 117961, 96899, 1719, 42547, 51303, 118040, 118078, 29514, 117844, 118091, 19711, 40132, 108013, 118157, 13424, 51488, 32264, 96377, 56172, 117293, 107139, 118176, 51228, 118218, 40557, 29776, 45792, 51507, 117913, 43695, 18593, 30203, 430, 28837, 118253, 99037, 55110, 56519, 40201, 117389, 30859, 105013, 118124, 86638, 118293, 117674, 118085, 31420, 30012, 37946, 16939, 81886, 53354, 8288, 9432, 118312, 118324, 28176, 118317, 51523, 7324, 29963, 85221, 51037, 118338, 118344, 29665, 34622, 118449, 95102, 30024, 34620, 51577, 33273, 118348, 118349, 118352, 834, 55620, 118601, 118586, 7702, 5403, 78984, 105929, 81501, 9701, 118661, 97611, 12814, 118036, 118082, 1085, 95246, 118678, 118674, 50845, 115212, 118694, 118690, 14852, 118691, 116507, 118693, 118708, 118725, 9107, 95983, 18028, 12244, 118764, 92160, 118728, 108469, 118824, 49610, 118850, 8861, 118722, 118720, 17171, 18350, 37375, 22063, 114072, 118819, 14064, 118777, 54788, 32920, 42061, 118842, 118738, 118925, 118916, 118919, 118921, 118923, 118924, 118679, 118840, 91852, 118843, 105732, 118845, 83203, 99294, 91308, 42775, 3271, 13941, 118968, 21977, 119100, 119104, 119099, 119150, 12781, 96259, 104298, 119238, 119245, 119239, 119253, 119257, 53843, 119270, 119445, 14072);

    
//    $criteria->addInCondition ('t.RocId', array(12953));
//    $criteria->addInCondition ('t.RocId', array(12953, 15648));

//    $criteria->addNotInCondition('t.RocId', array(8105, 8891, 12959, 14585, 15648, 16142, 22636, 34520, 44330, 53517, 84501, 86941, 101876, 121827, 106920, 101629, 86757, 55266, 51507, 35587, 30743, 19236, 15769, 15132, 14287, 1196, 427));

//    $rocids = file($_SERVER['DOCUMENT_ROOT'] . '/users.csv');
//    $criteria->addInCondition('t.RocId', $rocids);

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
//      print $url;
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
    $this->mail->LastName = $user->LastName;
    $this->mail->FatherName = $user->FatherName;
    $this->mail->RocId = $user->RocId;
    
//    $this->mail->RoleName = $user->EventUsers[0]->EventRole->Name;

    //    if (!empty($user->EventUsers) && $user->EventUsers[0]->RoleId != 1)
    //    {
    //      return;
    //    }

    $this->mail->RegLink = $this->getRegLink($user);
//    $this->mail->RegLinkRiw = $this->getRegLink($user);
    
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
//    $mail->AddAddress('i.matvienko@icontext.ru');
    $mail->AddAddress($email);
    $mail->SetFrom('info@in-numbers.ru', 'Интернет в цифрах', false);
    $mail->CharSet = 'utf-8';
    $mail->Subject = '=?UTF-8?B?'. base64_encode('"Бизнес мёртвых деревьев" на МКВЯ 2012') .'?=';
    $mail->Body = $this->mail;

    //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2012-06-18/forumspb12/postrelease.doc');
//    $mail->AddAttachment('spic-attach.docx', 'СПИК_итоги.docx');

//    $mail->Send();
//    echo $this->mail;
  }
  
  /**
   * @param User $user
   * @return string
   */
  private function getRegLink($user)
  {
    $secret = 'gQVcymFs5NkY0jjNOxuRcfkKC'; // rocid.ru  (i-research)
//    $secret = 'vyeavbdanfivabfdeypwgruqe'; // common
//    $secret = '131f6492c4a806a9'; // gm2012

    $timestamp = time();
    $rocid = $user->RocId;
    
    $hash = substr(md5($rocid . $secret . $timestamp), 0, 8); // rocid.ru
//    $hash = substr(md5($rocid.$secret), 0, 16);	// all sites

   	return 'http://rocid.ru/i-research/approve/vote/' . $rocid . '/' . $timestamp . '/' . $hash . '/';
//    return 'http://sp-ic.ru/my/?ROCID=' . $rocid . '&KEY=' . $hash;
//    return 'http://siteconf.ru/my/?ROCID=' . $rocid . '&KEY=' . $hash;
//    return 'http://2012.russianinternetweek.ru/my/' . $rocid . '/' . $hash .'/';
//			return 'http://rocid.ru/gm2012/' . $rocid . '/32/' . $hash;

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
