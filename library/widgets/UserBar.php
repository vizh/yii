<?php
AutoLoader::Import('library.widgets.userbar.*');
AutoLoader::Import('library.rocid.event.*');

class UserBar extends AbstractWidget
{
  const CacheCountEventUsersKey = 'CountEventUsers';

  public function __construct()
  {
    $this->view = new View();

    $countEventUsers = Registry::GetCache()->get(self::CacheCountEventUsersKey);
    if ($countEventUsers === false)
    {
      $countEventUsers = EventUser::AllCount();
      Registry::GetCache()->set(self::CacheCountEventUsersKey, $countEventUsers, 15*60);
    }
    $this->view->CountEventUsers = $countEventUsers;

    $loginUser = Registry::GetVariable('LoginUser');
    if (!empty($loginUser))
    {
      $this->processAuthBar($loginUser);
    }
    else
    {
      $this->processNonAuthBar();
    }
  }

  /**
   * @param User $loginUser
   * @return void
   */
  private function processAuthBar($loginUser)
  {
    $this->CommandView()->HeadScript(array('src'=>'/js/search.ind.js'));

    $this->view->SetTemplate('auth', 'core', 'userbar', 'widgets', 'public');

    $this->view->RocId = $loginUser->RocId;
    $this->view->Photo = $loginUser->GetMiniPhoto();

    $this->view->FullName = $loginUser->GetFullName();
  }

  private function processNonAuthBar()
  {
    $this->CommandView()->HeadScript(array('src'=>'/js/search.ind.js'));
    $this->CommandView()->HeadScript(array('src'=>'/js/userbar.js?1.1.4'));
    $this->view->SetTemplate('nonauth', 'core', 'userbar', 'widgets', 'public');

    $view = new View();
    $view->SetTemplate('popup-login', 'core', 'userbar', 'widgets', 'public');

    $view->AuthForm = new AuthUserForm();
    $view->RegForm = new RegistrationForm();

    $this->view->PopUpLogin = $view;
  }
}
