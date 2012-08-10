<?php
namespace ruvents\components;

class Exception extends \CException
{
  /**
   * @param int $code
   * @param array $params
   */
  public function __construct($code, $params = array())
  {
    parent::__construct($this->getErrorMessage($code, $params), $code);
  }

  private $codes = array(
    100 => 'Обработана внешняя ошибка: %s',

    /** авторизация операторов */
    101 => 'Не верная пара Логин/Пароль. Авторизация оператора отклонена!',
    102 => 'Не верный мастер-пароль. Авторизация оператора отклонена!',




    111 => 'Не верный токен следующей страницы данных',
  );




  /**
   * @param int $code
   * @param array $params
   * @return string
   */
  private function getErrorMessage($code, $params = array())
  {
    $message = isset($this->codes[$code]) ? $this->codes[$code] : 'Возникла ошибка с неизвестным кодом.';
    return call_user_func_array('sprintf', array_merge(array($message), $params));
  }

  public function sendResponse()
  {
    $error = new \stdClass();
    $error->Code = $this->getCode();
    $error->Message = $this->getMessage();
    echo json_encode(array('Error' => $error));
  }
}