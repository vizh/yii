<?php
AutoLoader::Import('main.public.MainRecovery');
 
class MainRecoveryPassword extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @param string $success
   * @return void
   */
  protected function doExecute($success = '')
  {
    if (! empty($this->LoginUser))
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index'));
    }

    if ($success == 'success')
    {
      $this->view->SetTemplate('success');
      echo $this->view;
      return;
    }

    $rocid = intval(Registry::GetRequestVar('rocid', 0));
    $code = Registry::GetRequestVar('code', '');
    $time = intval(Registry::GetRequestVar('time', 0));

    $user = User::GetByRocid($rocid);
    $error = '';
    if (empty($user))
    {
      $error = 'Пользователь с rocID ' . $rocid . ' не найден. Запросите ссылку повторно.';
    }
    elseif ($code != MainRecovery::GetCode($user, $time))
    {
      $error = 'Ссылка на восстановление пароля повреждена. Запросите ссылку повторно.';
    }
    elseif ($time + 24*60*60 < time())
    {
      $error = 'Ссылка на восстановление пароля устарела. Запросите ссылку повторно.';
    }

    if (! empty($error))
    {
      $this->showError($error);
      return;
    }

    $data = array('password' => '', 'password2' => '');
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $data = Registry::GetRequestVar('data');
      if ($data['password'] !== $data['password2'])
      {
        $this->AddErrorNotice('Ошибка восстановления пароля', 'Подтверждение пароля введено не верно.');
      }
      elseif (empty($data['password']) || empty($data['password2']))
      {
        $this->AddErrorNotice('Ошибка восстановления пароля', 'Новый пароль не может быть пустым');
      }
      else
      {
        $user->Password = User::GetPasswordHash($data['password']);
        $user->save();
        Lib::Redirect(RouteRegistry::GetUrl('main', 'recovery', 'password', array('success' => 'success')));
      }
    }

    $this->view->RocId = $rocid;
    $this->view->Data = $data;
    echo $this->view;
  }

  private function showError($message)
  {
    $this->view->SetTemplate('error');
    $this->view->Message = $message;
    echo $this->view;
  }
}
