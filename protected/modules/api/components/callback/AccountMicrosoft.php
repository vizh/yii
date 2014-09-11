<?php
namespace api\components\callback;

class AccountMicrosoft extends Base
{
  protected function getUrlRegisterOnEvent()
  {
    return 'http://rusites.cloudapp.net/payment/paycallback?provider=runet';
  }

  protected function getErrorMessage($code)
  {
    $errors = [
      3001 => 'Не найден ExternalId для пользователя с Id: %s',
      3002 => 'Не корректное обращение к callback url.'
    ];
    return isset($errors[$code]) ? $errors[$code] : parent::getErrorMessage($code);
  }


  public function registerOnEvent(\user\models\User $user, \event\models\Role $role)
  {
    $url = $this->getUrlRegisterOnEvent();
    if ($url !== null)
    {
      $externalUser = \api\models\ExternalUser::model()
          ->byUserId($user->Id)->byAccountId($this->account->Id)->find();
      if ($externalUser == null)
      {
        $this->logError(3001, [$user->Id]);
        \Yii::log('MICROSOFT!!! Не найден ExternalId для пользователя c Id: ' . $user->Id, \CLogger::LEVEL_ERROR);
        return;
      }

      $data = new \stdClass();
      $data->ApiKey = $this->account->Key;
      $data->ExternalId = $externalUser->ExternalId;
      $data->RoleId = $role->Id;
      $data->Hash = md5($this->account->Key.$externalUser->ExternalId.$role->Id.$this->account->Secret);

      $params = ['PayData' => json_encode($data)];
      $result = $this->sendMessage($url, $params, true);
      $resultObject = json_decode($result);

      if (!isset($resultObject->Success) || !$resultObject->Success)
      {
        $this->log->ErrorCode = 3002;
        $this->log->ErrorMessage = $this->getErrorMessage(3002);
        $this->log->save();
        \Yii::log('MICROSOFT!!! Не корректное обращение к callback url. Ответ сервера: ' . $result . "\r\n" . var_export($params, true), \CLogger::LEVEL_ERROR);
      }
    }
  }
}