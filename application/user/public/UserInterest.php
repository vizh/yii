<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.activity.*');

class UserInterest extends GeneralCommand
{
  private static $actions = array('add', 'delete');

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($action = '', $rocID = '')
  {
    $rocID = intval($rocID);
    if ($this->LoginUser == null || ! in_array($action, self::$actions) || $rocID == 0)
    {
      Lib::Redirect('/');
    }
    $user = User::GetByRocid($rocID);
    if ($user == null)
    {
      Lib::Redirect('/');
    }
    if ($action == 'add')
    {
      $interest = UserInterestPerson::GetUserInterestPerson($this->LoginUser->UserId, $user->UserId);
      if ($interest == null)
      {
        $interest = new UserInterestPerson();
        $interest->UserId = $this->LoginUser->UserId;
        $interest->InterestUserId = $user->UserId;
        $interest->save();
      }
    }
    else
    {
      $interest = UserInterestPerson::GetUserInterestPerson($this->LoginUser->UserId, $user->UserId);
      if ($interest != null)
      {
        $interest->delete();
      }
    }
    Lib::Redirect('/' . $rocID . '/');
  }
}
