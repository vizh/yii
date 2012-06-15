<?php
AutoLoader::Import('library.rocid.user.*');

class UserLogin extends ApiCommand
{
  /** @var User */
  private $user = null;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $rocid = intval(Registry::GetRequestVar('RocId', null));
    $email = Registry::GetRequestVar('Email', null);
    $password = Registry::GetRequestVar('Password');
    $password2 = Registry::GetRequestVar('PasswordCp1251', '');
    $force = Registry::GetRequestVar('Force', false);

    if (!empty($rocid))
    {
      $this->user = User::GetByRocid($rocid);
    }
    elseif (! empty($email))
    {
      $this->user = User::GetByEmail($email);
    }
    else
    {
      throw new ApiException(110);
    }

    if ($this->user != null && $this->user->CheckLoginByHash($password, $password2))
    {
      $this->Account->DataBuilder()->CreateUser($this->user);
      $this->Account->DataBuilder()->BuildUserEmail($this->user);
      $this->Account->DataBuilder()->BuildUserEmployment($this->user);
      $result = $this->Account->DataBuilder()->BuildUserEvent($this->user);

      $this->SendJson($result);
    }
    else
    {
      throw new ApiException(201);
    }
  }
}