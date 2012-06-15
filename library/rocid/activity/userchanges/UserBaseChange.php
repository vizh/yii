<?php

abstract class UserBaseChange
{
  /**
   * @var User
   */
  protected $user;

  /**
   * @param User $user
   * @return void
   */
  public function SetUser($user)
  {
    $this->user = $user;
  }

  /**
   * @static
   * @param int $userId
   * @param UserBaseChange $change
   * @return void
   */
  protected static function Save($userId, $change)
  {
    $userChange = new UserChanges();
    $userChange->UserId = $userId;
    $userChange->SetAction($change);
    $userChange->CreationTime = time();
    $userChange->save();
  }

  /**
   * @abstract
   * @return View
   */
  abstract public function GetView();
}