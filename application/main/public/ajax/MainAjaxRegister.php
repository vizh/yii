<?php
AutoLoader::Import('main.source.*');

class MainAjaxRegister extends AjaxAuthCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $result = array('error' => true, 'message' => '');

    $regform = new RegistrationForm();
    if ($regform->IsRequest())
    {
      if ($regform->Validate())
      {
        $user = User::Register($regform->GetEmail(), $regform->GetPassword());
        if ($user != null)
        {
          $user->LastName = $regform->GetLastName();
          $user->FirstName = $regform->GetFirstName();
          $user->save();
          $identity = new RocidIdentity($user->GetRocId(), $regform->GetPassword());
          $identity->authenticate();
          if ($identity->errorCode == CUserIdentity::ERROR_NONE)
          {
            Yii::app()->user->login($identity, $identity->GetExpire());
          }
          $result['error'] = false;
        }
        else
        {
          $result['message'] .= $this->GetErrorNotice('Учётная запись с введённым вами email уже зарегистрирована.', 'Вероятнее всего вы уже регистрировались на сайте — попробуйте восстановить пароль.');
        }
      }
      else
      {
        $errors = $regform->GetErrors('lastname');
        if (in_array('NotEmpty', $errors))
        {
          $result['message'] .= $this->GetErrorNotice('Поле Фамилия не может быть пустым');
        }

        $errors = $regform->GetErrors('firstname');
        if (in_array('NotEmpty', $errors))
        {
          $result['message'] .= $this->GetErrorNotice('Поле Имя не может быть пустым');
        }

        $errors = $regform->GetErrors('email');
        if (in_array('NotEmpty', $errors))
        {
          $result['message'] .= $this->GetErrorNotice('Поле Email не может быть пустым');
        }
        if (in_array('Email', $errors))
        {
          $result['message'] .= $this->GetErrorNotice('Введенное значение поля Email некорректно');
        }

        $errors = $regform->GetErrors('password');
        if (in_array('NotEmpty', $errors))
        {
          $result['message'] .= $this->GetErrorNotice('Поле пароль не может быть пустым');
        }
      }
    }

    echo json_encode($result);
  }
}
