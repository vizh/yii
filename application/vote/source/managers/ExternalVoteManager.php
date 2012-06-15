<?php

class ExternalVoteManager extends BaseVoteManager
{

  /**
   * @return array
   */
  private function getVoterInfoArray()
  {
    return array(
      'Agent' => $_SERVER['HTTP_USER_AGENT'],
      'Ip' => $_SERVER['REMOTE_ADDR'],
      'DateTime' => date('Y-m-d H:i:s')
    );
  }


  /**
   * @return bool
   */
  public function CheckVoter()
  {
    $key = md5($this->sessionKey());
    $value = Cookie::Get($key);
    if ($value == null || intval(base64_decode($value)) < 2)
    {
      return true;
    }
    return false;
  }

  /**
   * @return string
   */
  protected function getVoterHash()
  {
    $data = $this->getVoterInfoArray();
    return md5($data['Ip']);
  }

  /**
   * @return string
   */
  protected function getVoterInfo()
  {
    $data = $this->getVoterInfoArray();
    return base64_encode(serialize($data));
  }

  /**
   *
   */
  protected function afterFinishVote()
  {
    $key = md5($this->sessionKey());

    $value = Cookie::Get($key);
    $value = $value !== null ? intval(base64_decode($value))+1 : 1;

    $cookie = new CHttpCookie($key, base64_encode($value));
    $cookie->expire = time() + 60 * 24 * 60 * 60;
    Cookie::Set($cookie);
  }
}
