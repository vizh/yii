<?php
AutoLoader::Import('library.mail.*');

class MainRecovery extends GeneralCommand
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

    $email = '';
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $email = Registry::GetRequestVar('email');
      
      $validator = new CEmailValidator();
      if (empty($email) || !$validator->validateValue($email))
      {
        $this->AddErrorNotice('Ошибка восстановления пароля','Не задан электронный адрес или задан некорретно.');
      }
      else
      {
        $user = User::GetByEmail($email);
        if (empty($user))
        {
          $this->AddErrorNotice('Ошибка восстановления пароля','Пользователь с таким электронным адресом не найден.');
        }
        else
        {
          $this->sendEmail($user);
          Lib::Redirect(RouteRegistry::GetUrl('main', '', 'recovery', array('success' => 'success')));
        }
      }
    }

    $this->view->Email = $email;
    echo $this->view;
  }

  /**
   * @param User $user
   * @return void
   */
  private function sendEmail($user)
  {
    $view = new View();
    $view->SetTemplate('email');
    $view->LastName = $user->LastName;
    $view->FirstName = $user->FirstName;
    $time = time();
    $code =self::GetCode($user, $time);
    $view->Url = RouteRegistry::GetUrl('main', 'recovery', 'password') . '?' . http_build_query(array('rocid' => $user->RocId, 'code' => $code, 'time' => $time));
    $view->Host = $_SERVER['HTTP_HOST'];

    $mail = new PHPMailer(false);

    $mail->AddAddress($user->Email);
    $mail->SetFrom('support@rocid.ru', 'rocID', false);
    $mail->CharSet = 'utf-8';
    $subject = Registry::GetWord('mail');
    $subject = (string)$subject['recovery'];
    $mail->Subject = '=?UTF-8?B?'. base64_encode($subject) .'?=';
    $mail->AltBody = 'Для просмотра этого сообщения необходимо использовать клиент, поддерживающий HTML';
    $mail->MsgHTML($view);
    $mail->Send();
  }

  /**
   * @param User $user
   * @param int $time
   * @return string
   */
  public static function GetCode($user, $time)
  {
    return substr(md5($user->UserId . $user->Password . $time), 0, 16);
  }
}
