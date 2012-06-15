<?php
AutoLoader::Import('library.rocid.user.*');

class UserGet extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $rocid = intval(Registry::GetRequestVar('RocId', null));

    $user = User::GetByRocid($rocid);

    if ($user !== null)
    {
      $this->Account->DataBuilder()->CreateUser($user);
      $this->Account->DataBuilder()->BuildUserEmail($user);
      $this->Account->DataBuilder()->BuildUserEmployment($user);
      $result = $this->Account->DataBuilder()->BuildUserEvent($user);

      $this->SendJson($result);
    }
    else
    {
      throw new ApiException(202, array($rocid));
    }
  }
}
