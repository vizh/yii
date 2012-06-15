<?php
AutoLoader::Import('research.source.*');

class ResearchApprove extends GeneralCommand
{
  private static $secret = 'gQVcymFs5NkY0jjNOxuRcfkKC';

  /**
   * Основные действия комманды
   * @param int $rocId
   * @param int $timestamp
   * @param string $hash
   * @return void
   */
  protected function doExecute($rocId = 0, $timestamp = 0, $hash = '')
  {
//    if ($this->getHash($rocId, $timestamp) != $hash)
//    {
//      $this->Send404AndExit();
//    }
//
//    if ($this->LoginUser == null || $this->LoginUser->RocId != $rocId)
//    {
//      $identity = new FastAuthIdentity($rocId);
//      $identity->authenticate();
//      if ($identity->errorCode == CUserIdentity::ERROR_NONE)
//      {
//        Yii::app()->user->login($identity, $identity->GetExpire());
//        Lib::Redirect(RouteRegistry::GetUrl('research', '', 'approve', array('rocId' => $rocId, 'timestamp' => $timestamp, 'hash' => $hash)));
//       }
//      else
//      {
//        $this->Send404AndExit();
//      }
//    }
    /** @var $trends Trend[] */
    $trends = Trend::model()->findAll();

    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $trendResult = Registry::GetRequestVar('Trend', array());
      if (sizeof($trendResult) <= 2)
      {
        Trend::model()->RemoveTrends($this->LoginUser);
        foreach ($trends as $trend)
        {
          if (in_array($trend->TrendId, $trendResult))
          {
            $trend->AddUser($this->LoginUser);
          }
        }
        $this->view->SetTemplate('success');
      }
    }

    $userTrends = Trend::model()->byUser($this->LoginUser)->findAll();
    $userTrendId = array();
    foreach ($userTrends as $trend)
    {
      $userTrendId[] = $trend->TrendId;
    }

    $this->view->Trends = $trends;
    $this->view->UserTrendId = $userTrendId;
    $this->view->LoginUser = $this->LoginUser;
    foreach ($this->LoginUser->Employments as $employment)
    {
      if ($employment->Primary == 1)
      {
        $this->view->Employment = $employment;
        break;
      }
    }
    $this->view->Email = !empty($this->LoginUser->Emails) ? $this->LoginUser->Emails[0]->Email : $this->LoginUser->Email;
    foreach ($this->LoginUser->Phones as $phone)
    {
      $this->view->Phone = $phone->Phone;
      if ($phone->Type = ContactPhone::TypeMobile)
      {
        break;
      }
    }
    echo $this->view;
  }

  private function getHash($rocId, $timestamp)
  {
    return substr(md5($rocId . self::$secret . $timestamp), 0, 8);
  }
}
