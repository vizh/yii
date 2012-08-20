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



    110 => 'Не задан обязательный параметр метода',
    111 => 'Не верный токен следующей страницы данных',


    /* Ошибки работы с модулем User */
    202 => 'Не найден пользователь с rocID: %s',
    203 => 'Строка запроса не может быть пустой',

    205 => 'Введен не корректный Email',
    206 => 'Пользователь с таким Email уже существует в системе rocID',
    
    207 => 'Ошибка создания пользователя: %s',


    /* Ошибки работы с модулем Event */
    301 => 'Не найдено мероприятие для текущего оператора',
    302 => 'Не найдена роль',
    303 => 'Пользователь уже зарегистрирован на мероприятие',
    304 => 'Пользователь не зарегистрирован на мероприятие',
    305 => 'Роль пользователя не изменилась на мероприятии',
    306 => 'На мероприятии отсутствует день с id: %s',
    308 => 'Для мероприятия не заданы отдельные дни. Указан избыточный праметр.',
    309 => 'Для мероприятия заданы отдельные дни. Необходимо указать id дня.',
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