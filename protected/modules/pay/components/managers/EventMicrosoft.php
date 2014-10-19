<?php
namespace pay\components\managers;


use pay\components\MessageException;

class EventMicrosoft extends EventProductManager
{
  const CallbackUrl = 'http://rusites.cloudapp.net/payment/paycallback?provider=runet';

//  protected function internalBuy($user, $orderItem = null, $params = array())
//  {
//    if (parent::internalBuy($user, $orderItem, $params))
//    {
//      //$this->sendMessage($user, $this->RoleId);
//    }
//    return true;
//  }

  protected function internalChangeOwner($fromUser, $toUser, $params = array())
  {
    $participant = \event\models\Participant::model()
        ->byUserId($fromUser->Id)->byEventId($this->product->EventId)->find();
    if ($participant !== null)
    {
      $role = \event\models\Role::model()->findByPk(24);
      $this->product->Event->registerUser($fromUser, $role);
    }

    return $this->internalBuy($toUser);
  }

  /**
   * @param \user\models\User $user
   * @param int $roleId
   */
  protected function sendMessage($user, $roleId)
  {
    $externalUser = \api\models\ExternalUser::model()
        ->byUserId($user->Id)->byAccountId($this->getAccount()->Id)->find();
    if ($externalUser == null)
    {
      \Yii::log('MICROSOFT!!! Не найден ExternalId для пользователя c Id: ' . $user->Id, \CLogger::LEVEL_ERROR);
      return;
    }
    $data = new \stdClass();
    $data->ApiKey = $this->getAccount()->Key;
    $data->ExternalId = $externalUser->ExternalId;
    $data->RoleId = $roleId;
    $data->Hash = md5($this->getAccount()->Key.$externalUser->ExternalId.$roleId.$this->getAccount()->Secret);
    $params = ['PayData' => json_encode($data)];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, self::CallbackUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    $result = curl_exec($curl);

    $errno = curl_errno($curl);
    if ($errno != 0)
    {
      \Yii::log('MICROSOFT!!! Не корректное обращение к callback url. Ошибка номер: ' . $errno, \CLogger::LEVEL_ERROR);
    }
    $resultObject = json_decode($result);

    if (!isset($resultObject->Success) || !$resultObject->Success)
    {
      \Yii::log('MICROSOFT!!! Не корректное обращение к callback url. Ответ сервера: ' . $result . "\r\n" . var_export($params, true), \CLogger::LEVEL_ERROR);
    }
    curl_close($curl);
  }

  protected $account = null;

  /**
   * @return \api\models\Account
   */
  protected function getAccount()
  {
    if ($this->account == null)
    {
      $this->account = \api\models\Account::model()->byEventId($this->product->EventId)->find();
      if ($this->account == null) {
          throw new MessageException('Не найден api аккаунт мероприятия, для совершения callback');
      }
    }

    return $this->account;
  }
}