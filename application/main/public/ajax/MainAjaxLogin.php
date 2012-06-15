<?php
AutoLoader::Import('library.widgets.userbar.*');
AutoLoader::Import('main.source.*');

class MainAjaxLogin extends AjaxAuthCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $result = array('error' => true, 'message' => '');
    $authform = new AuthUserForm();

    if ($authform->IsRequest())
		{
			if ($authform->Validate())
			{
        $identity = null;
        $validator = new CEmailValidator();
        if ($validator->validateValue($authform->GetRocidOrEmail()))
        {
          $identity = new EmailIdentity($authform->GetRocidOrEmail(), $authform->GetPassword());
        }
        else
        {
          $identity = new RocidIdentity($authform->GetRocidOrEmail(), $authform->GetPassword());
        }
        $identity->authenticate();
				if ($identity->errorCode == CUserIdentity::ERROR_NONE)
				{
          $result['error'] = false;
          if ($authform->NotRemember())
          {
            Yii::app()->user->login($identity);
          }
          else
          {
            Yii::app()->user->login($identity, $identity->GetExpire());
          }
				}
				else
				{
					$result['message'] .= $this->GetErrorNotice('Неправильная пара Email / rocID - пароль!', 'Авторизоваться не удалось');
				}
			}
			else
			{
				$errors = $authform->GetErrors('rocid_or_mail');
				if (in_array('NotEmpty', $errors))
				{
					$result['message'] .= $this->GetErrorNotice('Поле Email / rocID не может быть пустым');
				}

				$errors = $authform->GetErrors('password');
				if (in_array('NotEmpty', $errors))
				{
					$result['message'] .= $this->GetErrorNotice('Поле пароль не может быть пустым');
				}
			}
		}

    echo json_encode($result);
  }
}
