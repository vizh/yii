<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 26.04.12
 * Time: 16:06
 * To change this template use File | Settings | File Templates.
 */
class InternalVoteManager extends BaseVoteManager
{

  /**
   * @return bool
   */
  public function CheckVoter()
  {
    $loginUser = Registry::GetVariable('LoginUser');
    if ($loginUser == null)
    {
      return false;
    }
    $hash = $this->getVoterHash();
    $result = VoteResult::model()->byVote($this->vote->VoteId)->byHash($hash)->find();
    return $result == null;
  }

  /**
   * @return string
   */
  protected function getVoterHash()
  {
    $loginUser = Registry::GetVariable('LoginUser');
    if ($loginUser != null)
    {
      return md5($loginUser->UserId);
    }

    return null;
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
    // TODO: Implement afterFinishVote() method.
  }

  /**
   * @return array
   */
  private function getVoterInfoArray()
  {
    $loginUser = Registry::GetVariable('LoginUser');
    if ($loginUser != null)
    {
      return array(
        'Agent' => $_SERVER['HTTP_USER_AGENT'],
        'Ip' => $_SERVER['REMOTE_ADDR'],
        'DateTime' => date('Y-m-d H:i:s'),
        'UserId' => $loginUser->UserId
      );
    }
    return null;
  }
}
