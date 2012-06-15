<?php

class ResearchApproveVote extends GeneralCommand
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
    if ($this->getHash($rocId, $timestamp) != $hash)
    {
      $this->Send404AndExit();
    }

    if ($this->LoginUser == null || $this->LoginUser->RocId != $rocId)
    {
      $identity = new FastAuthIdentity($rocId);
      $identity->authenticate();
      if ($identity->errorCode == CUserIdentity::ERROR_NONE)
      {
        Yii::app()->user->login($identity, $identity->GetExpire());
      }
      else
      {
        $this->Send404AndExit();
      }
    }

    Lib::Redirect(RouteRegistry::GetUrl('research', '', 'vote'));
  }

  private function getHash($rocId, $timestamp)
  {
    return substr(md5($rocId . self::$secret . $timestamp), 0, 8);
  }
}
