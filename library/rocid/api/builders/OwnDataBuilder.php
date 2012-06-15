<?php

class OwnDataBuilder extends BaseDataBuilder
{

  /**
   * @param User $user
   * @return stdClass
   */
  public function BuildUserEmail($user)
  {
    if (!empty($user->Emails))
    {
      $this->user->Email = $user->Emails[0]->Email;
    }
    else
    {
      $this->user->Email = $user->Email;
    }

    return $this->user;
  }
}
