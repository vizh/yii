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
    103 => 'Оператор и хеш доступа принадлежат к разным мероприятиям',
    104 => 'Для загрузки списка операторов необходим хеш автризации',



    110 => 'Не задан обязательный параметр метода',
    111 => 'Не верный токен следующей страницы данных',


    /* Ошибки работы с модулем User */
    202 => 'Не найден пользователь с RUNET-ID: %s',
    203 => 'Строка запроса не может быть пустой',

    205 => 'Введен не корректный Email',
    206 => 'Пользователь с таким Email уже существует в системе RUNET-ID',
    
    207 => 'Ошибка сохранения пользователя: %s',


    /* Ошибки работы с модулем Event */
    301 => 'Не найдено мероприятие для текущего оператора',
    302 => 'Не найдена роль %d',
    303 => 'Пользователь уже зарегистрирован на мероприятие',
    304 => 'Пользователь не зарегистрирован на мероприятие',
    305 => 'Роль пользователя не изменилась на мероприятии',
    306 => 'На мероприятии отсутствует часть с id: %s',
    308 => 'Для мероприятия не заданы отдельные части. Указан избыточный праметр.',
    309 => 'Для мероприятия заданы отдельные части. Необходимо указать id части.',

    321 => 'Не передан обязательный параметр FromUpdateTime.',



    /**  Заказы **/


    408 => 'Передан пустой список заказов',
    409 => 'Не найдены элементы заказа с идентификаторами: %s',


    413 => 'Элементы заказа со следующими идентификаторами не принадлежат пользователю: %s',

    414 => 'Операция отменена. Не удалось перенести следующие заказы: %s',
      
      
    /** Поиск **/
    501 => 'Не задан поисковый запрос',

    /** Yii Exception */
    601 => 'Обработана ошибка Yii: %s',
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
    echo json_encode(array('Error' => $error), JSON_UNESCAPED_UNICODE);
  }
}