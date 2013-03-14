<?php
namespace pay\components\managers;

class InNumbersProductManager extends BaseProductManager
{
  const CallbackUrl = 'http://www.in-numbers.ru/subscribe/callback.php';
  const PrivateKey = '586f5ab0e13a03127a0dfa3af3';

  /**
   * Возвращает список доступных аттрибутов
   * @return string[]
   */
  public function GetAttributeNames()
  {
    return array();
  }

  /**
   * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  public function CheckProduct($user, $params = array())
  {
    // TODO: Implement CheckProduct() method.
    return true;
  }

  /**
   * Оформляет покупку продукта на пользователя
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  public function BuyProduct($user, $params = array())
  {
    $params = array();
    $params['rocid'] = $user->RocId;
    $params['key'] = self::PrivateKey;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, self::CallbackUrl . '?' . http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    if ($result != 'OK')
    {
      $this->sendErrorMail($user);
    }
    return true;
  }

  /**
   * @param \user\models\User $user
   */
  private function sendErrorMail($user)
  {
    $mail = new \PHPMailer(false);

    $mail->IsHTML(false);
    $mail->AddAddress('nikitin@internetmediaholding.com');
    $mail->AddAddress('korotov@internetmediaholding.com');
    $mail->SetFrom('error@rocid.ru', 'rocID Error', false);
    $mail->CharSet = 'utf-8';
    $mail->Subject = '=?UTF-8?B?'. base64_encode('Ошибка активации платежа in-numbers') .'?=';
    $mail->Body = 'Ошибка при активации оплаты журнала для пользователя с rocID: ' . $user->RocId . ' ' . $user->LastName . ' ' . $user->FirstName;
    $mail->Send();
  }

  /**
   * @param array $params
   * @param string $filter
   * @return array
   */
  public function Filter($params, $filter)
  {
    return array();
  }

  /**
   * @param array $params
   * @return \pay\models\Product
   */
  public function GetFilterProduct($params)
  {
    return $this->product;
  }

  /**
   * Отменяет покупку продукта на пользовтеля
   * @param \user\models\User $user
   * @return bool
   */
  public function RollbackProduct($user)
  {
    // TODO: Implement RollbackProduct() method.
  }

  /**
   *
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @return bool
   */
  public function RedirectProduct($fromUser, $toUser)
  {
    // TODO: Implement RedirectProduct() method.
  }
}
