<?php
AutoLoader::Import('library.rocid.company.*');

class UtilityClearHl12 extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    return;
    $criteria = new CDbCriteria();
    $criteria->condition = 't.Email LIKE :EmailPart';
    $criteria->params[':EmailPart'] = Utils::PrepareStringForLike('hl12+') . '%';

    $users = User::model()->findAll($criteria);

//    foreach ($users as $user)
//    {
//      $this->clearUser($user);
//    }

    echo sizeof($users);
  }

  /**
   * @param User $user
   */
  private function clearUser($user)
  {
    /** @var $eUsers EventUser[] */
    $eUsers = $user->EventUsers(array('condition' => 'EventUsers.EventId = 385'));
    if (!empty($eUsers))
    {
      $eUsers[0]->delete();
      foreach ($user->Employments as $employment)
      {
        $employment->delete();
      }
      foreach ($user->Emails as $email)
      {
        $email->delete();
      }
      $user->delete();
    }
  }
}
