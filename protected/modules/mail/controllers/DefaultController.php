<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($rocId = 0)
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
    AutoLoader::Import('vote.source.*');
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
    $criteria->addNotInCondition('t.UserId', $usersId);
//    $criteria->addInCondition('EventUsers.RoleId', array(24));

    //2
    // КРОМЕ ВИРТУАЛЬНЫЕ УЧАСТНИКИ
//    $criteria->addNotInCondition('EventUsers.RoleId', array(24));

    //3
    $criteria->addInCondition('EventUsers.RoleId', array(3, 6, 22, 23, 25));

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



  const Step = 500;

  public static $MailName = 'i-research-5';
  public static $EventIdName = 'spic12';

  /**
   * @var View
   */
  private $mail;

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
    $mail->SetFrom('research2012@raec.ru', 'РАЭК-исследование', false);
    $mail->CharSet = 'utf-8';
    $mail->Subject = '=?UTF-8?B?'. base64_encode('Последняя возможность стать экспертом Рунета 2012') .'?=';
    $mail->Body = $this->mail;

    //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2012-06-18/forumspb12/postrelease.doc');
//    $mail->AddAttachment('spic-attach.docx', 'СПИК_итоги.docx');

    //$mail->Send();
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
