<?php

/**
 * Пакет интеграции c API Деньги@Mail.Ru
 *
 * PHP Version 5.2
 *
 * @link https://money.mail.ru
 */

if (!function_exists('curl_init')) throw new Exception('MailRu_Money needs the CURL library');

if (!defined('MAILRU_MONEY_CERTIFICATE_PATH')) {
    /**
     * Путь к SSL сертификату Деньги@Mail.Ru
     */
    define('MAILRU_MONEY_CERTIFICATE_PATH', realpath(dirname(__FILE__)) . '/mailru-money.crt');
}

/**
 * Предоставляет доступ к программному интерфейсу Деньги@Mail.Ru
 *
 * @api
 * @package MailRu_Money
 */
class MailRu_Money extends MailRu_Money_Core
{
    /**
     * constructor
     *
     * @param string $apiKey Ключ доступа
     */
    public function __construct($apiKey)
    {
        parent::__construct($apiKey);
    }

    /**
     * Выставляет счет
     *
     * Дополнительные параметры запроса:
     * - message:    дополнительная информация о платеже
     * - valid_days: максимальное количество дней с момента выставления счета,
     *               в течение которых можно оплатить. Если параметр не указан,
     *               оплатить счет можно в течение любого времени
     * - valid_time: срок действия счета, установленный в виде точного времени
     * - keep_uniq:  поддерживать уникальность кода заказа. Если параметр указан,
     *               создание новых счетов с таким же issuer_id будет запрещено,
     *               а при попытке выставить повторный счет будет получена ошибка.
     *               Параметр игнорируется, если не указан issuer_id
     *
     * @param string  $buyerEmail  Адрес зарегистрированного пользователя системы
     * @param decimal $amount      Сумма счета в валюте счета
     * @param string  $currency    Код валюты счета (RUR)
     * @param string  $description Назначение платежа по счету
     * @param string  $buyerIp     IP-адрес покупателя, которому будет выставлен
     *                             счет
     * @param string  $issuerId    Уникальный код заказа по системе отправителя
     *                             счета. Может использоваться для определения
     *                             факта оплаты счета. Создание новых счетов с
     *                             таким же issuerId будет запрещено
     * @param array   $params      Дополнительные параметры
     *
     * @return string              Целое ненулевое двадцати-значное число - уникальный
     *                             идентификатор счета в Системе
     * @throws MailRu_Money_Exception
     */
    public function makeInvoice($buyerEmail, $amount, $currency, $description, $buyerIp, $issuerId = null, array $params = array())
    {
        $request = new MailRu_Money_Request_MakeInvoice($buyerEmail, $amount, $currency, $description, $buyerIp, $issuerId);
        $request->fromArray($params);
        return $this->getApiGateway()->doRequest($request)->getResult();
    }

    /**
     * Возвращает статус и информацию о счете
     *
     * @param string $invoiceNumber Номер счета, для которого проверяется
     *                              статус. Предполагается, что счет был
     *                              выставлен ранее
     * @param string $issuerId      Код заказа по системе отправителя счета
     *
     * @return MailRu_Money_Response_GetInvoice|null
     * @throws MailRu_Money_Exception За исключением MailRu_Money_Exception_Api
     *                                с кодом ERR_API_INVALID_ACCESS
     */
    public function getInvoice($invoiceNumber, $issuerId = null)
    {
        try {
            $request = new MailRu_Money_Request_GetInvoice($invoiceNumber, $issuerId);
            return $this->getApiGateway()->doRequest($request);
        } catch (MailRu_Money_Api_Exception $apiException) {
            if (self::ERR_API_INVALID_ACCESS == $apiException->getCode())
                return;
            throw $apiException;
        }
    }

    /**
     * Возвращает статус и информацию о счете по уникальному коду заказа в
     * системе отправителя
     *
     * @param string $issuerId Код заказа по системе отправителя счета
     *
     * @return MailRu_Money_Response_GetInvoice|null
     * @throws MailRu_Money_Exception За исключением MailRu_Money_Exception_Api
     *                                с кодом ERR_API_INVALID_ACCESS
     */
    public function getInvoiceByIssuerId($issuerId)
    {
        return $this->getInvoice(null, $issuerId);
    }

    /**
     * Возвращает текущее состояние платежного баланса магазина
     *
     * @param string $currency Код валюты (по умолчанию используется RUR)
     *
     * @return array
     * @throws MailRu_Money_Exception
     */
    public function getBalance($currency = null)
    {
        $request = new MailRu_Money_Request();
        $request->setMethod('info.balance')
                ->setCurrency($currency);
        return $this->getApiGateway()->doRequest($request)->toArray();
    }

    /**
     * Проверка существования счета пользователя
     *
     * @param string $rcpt     Адрес зарегистрированного пользователя системы
     * @param string $currency Код валюты счета (RUR)
     *
     * @return string|null            Адрес пользователя системы
     * @throws MailRu_Money_Exception За исключением MailRu_Money_Exception_Api
     *                                с кодом ERR_API_NO_SUCH_USER
     */
    public function checkUser($rcpt, $currency = null)
    {
        $request = new MailRu_Money_Request();
        $request->setMethod('user.check')
                ->setRcpt($rcpt)
                ->setShowUser(true)
                ->setCurrency($currency);
        try {
            $response = $this->getApiGateway()->doRequest($request);
        } catch (MailRu_Money_Api_Exception $apiException) {
            if (self::ERR_API_NO_SUCH_USER == $apiException->getCode())
                return;
            throw $apiException;
        }
        return $response->getUser();
    }

    /**
     * Возвращает адрес пользователя, которому принадлежит указанный счет
     *
     * @param string $account Номер счета пользователя
     *
     * @return string|null            Адрес пользователя системы
     * @throws MailRu_Money_Exception За исключением MailRu_Money_Exception_Api
     *                                с кодом ERR_API_NO_SUCH_USER
     */
    public function getUserByAccount($account)
    {
        return $this->checkUser($account);
    }

    /**
     * Возвращает список доступных валют
     *
     * @param string $currency Код валюты (RUR). Если указан, будет выведена
     *                         информация только о валюте с этим кодом
     *
     * @return array
     * @throws MailRu_Money_Exception
     */
    public function getCurrency($currency = null)
    {
        $request = new MailRu_Money_Request();
        $request->setMethod('info.currency')->setCurrency($currency);
        return $this->getApiGateway()->doRequest($request)->toArray();
    }

}


/**
 * Core
 *
 * @package    MailRu_Money
 * @subpackage Core
 */
abstract class MailRu_Money_Core
{
    /**
     * Версия
     */
    const VERSION = '0.1.120412';
    /**
     * Адрес программного интерфейса Деньги@Mail.Ru. Схема взаимодействия "Стандарт"
     */
    const API_BASE_URI = 'https://merchant.money.mail.ru/api-json';
    /**
     * Адрес программного интерфейса схемы взаимодействия "Лайт"
     */
    const LIGHT_BASE_URI = 'https://money.mail.ru/pay/light';
	/**
     * Демо схемы взаимодействия "Лайт"
     */
    const LIGHT_BASE_URI_DEMO = 'https://demo.money.mail.ru/pay/light';

    /**
     * Коды ошибок API
     */
    /**
     * E0001: Переданы неизвестные значения параметров
     */
    const ERR_API_INVALID_PARAMETERS    = 'E0001';
    /**
     * E0002: Магазин, от которого осуществляется попытка выполнить операцию,
     * блокирован в Системе или секретный ключ, указанный в параметрах операции,
     * не опознан
     */
    const ERR_API_INVALID_ISSUER        = 'E0002';
    /**
     * E0003: Пользователь на email, которого выставляется счет,
     * не зарегистрирован в Системе
     */
    const ERR_API_NO_SUCH_USER          = 'E0003';
    /**
     * E0004: Пользователь на email, которого выставляется счет, заблокирован
     * в Системе
     */
    const ERR_API_USER_IS_BLOCKER       = 'E0004';
    /**
     * E0005: Информация о счете/платеже не найдена
     */
    const ERR_API_INVALID_ACCESS        = 'E0005';
    /**
     * E0006: Счет не выставлен из-за технического сбоя в Системе. Необходимо
     * повторить запрос или связаться со службой технической поддержки
     */
    const ERR_API_FAILURE               = 'E0006';
    /**
     * E0007: Некорректно указан адрес электронной почты получателя
     */
    const ERR_API_INVALID_BUYER         = 'E0007';
    /**
     * E1001: Система временно не производит операции в указанной валюте или
     * валюта указана не верно
     */
    const ERR_API_UNAVAILABLE_CURRENCY  = 'E1001';
    /**
     * E1002: Магазину запрещено выставлять счета в этой валюте
     */
    const ERR_API_DISALLOWED_CURRENCY   = 'E1002';
    /**
     * E1003: Магазин временно не может выполнять операции из-за достигнутых
     * количественных или финансовых ограничений
     */
    const ERR_API_LIMITS                = 'E1003';
    /**
     * E1006: Сумма счета меньше допустимой для этой валюты
     */
    const ERR_API_LIMIT_LESS            = 'E1006';
    /**
     * E1007: Сумма счета больше допустимой для этой валюты
     */
    const ERR_API_LIMIT_GREATER         = 'E1007';
    /**
     * E1008: Счет с таким issuer_id уже выставлен
     */
    const ERR_API_DUPLICATE_TRANSACTION = 'E1008';
    /**
     * E1009: Доступ с IP адреса магазина запрещен
     */
    const ERR_API_ACCESS_DENIED         = 'E1009';

    /**
     * Коды статусов обработки уведомлений от системы Деньги@Mail.Ru,
     * используется в ответе магазина Системе
     */
    /**
     * S0001: Техническая ошибка на стороне магазина
     */
    const STATUS_CODE_ERR_SYSTEM            = 'S0001';
    /**
     * S0002: Некорректный формат уведомления
     */
    const STATUS_CODE_ERR_WRONG_STRUCT      = 'S0002';
    /**
     * S0003: Ошибка проверки цифровой подписи
     */
    const STATUS_CODE_ERR_INVALID_SIGNATURE = 'S0003';
    /**
     * S0004: Уведомление уже обработано. Остановить уведомления
     */
    const STATUS_CODE_ERR_ALREADY           = 'S0004';

    /**
     * Типы цифровых подписей
     */
    const SIGN_TYPE_MD5         = 'MD5';
    const SIGN_TYPE_SHA1        = 'SHA';
    const SIGN_TYPE_SHA256      = 'SHA256';
    const SIGN_TYPE_HMAC_MD5    = 'HMAC_MD5';
    const SIGN_TYPE_HMAC_SHA1   = 'HMAC_SHA';
    const SIGN_TYPE_HMAC_SHA256 = 'HMAC_SHA256';

    /**
     * Настройки CURL
     * @var array
     * @static
     */
    public static $CURL_OPTIONS = array(
        CURLOPT_USERAGENT => 'mailru-money-php-0.1.120412',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_CAINFO  => MAILRU_MONEY_CERTIFICATE_PATH,
    );

    /**
     * Ключ доступа к API
     * @var string
     */
    protected $apiKey;

    /**
     * Шлюз доступа к API
     * @var MailRu_Money_Gateway_Abstract
     */
    protected $apiGateway;

    /**
     * 	constructor
     *
     * @param string $apiKey Ключ доступа к API
     *
     * @return MailRu_Money
     */
    protected function __construct($apiKey)
    {
        $this->setApiKey($apiKey);
        return $this;
    }

    /**
     * Возвращает ключ доступа API
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Устанавливает ключ доступа API
     *
     * @param string $apiKey
     *
     * @return MailRu_Money
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * Устанавливает используемый шлюз доступа к API
     *
     * @param MailRu_Money_Gateway_Abstract $gateway
     *
     * @return MailRu_Money
     */
    public function setApiGateway(MailRu_Money_Gateway_Abstract $gateway)
    {
        $gateway->bind($this);
        $this->apiGateway = $gateway;
        return $this;
    }

    /**
     * Возвращает текущий шлюз доступа к API
     *
     * @return MailRu_Money_Gateway_Abstract
     */
    public function getApiGateway()
    {
        if (!isset($this->apiGateway)) {
            $this->setApiGateway(new MailRu_Money_Gateway_Api());
        }
        return $this->apiGateway;
    }
}

/**
 * Исключение сгенерированное на уровне приложения
 *
 * @package    MailRu_Money
 * @subpackage Core
 */
class MailRu_Money_Exception extends Exception
{
    /**
     * __toString()
     *
     * @return string
     */
    public function __toString()
    {
        return "exception '" . get_class($this)
            . "' with message '{$this->message}' in "
            . basename($this->file) . ':' . $this->line;
    }
}

/**
 * Исключение программного интерфейса Деньги@Mail.Ru
 *
 * @package    MailRu_Money
 * @subpackage Core
 *
 * @see        Money_Core::ERR_*
 */
class MailRu_Money_Api_Exception extends MailRu_Money_Exception
{
    /**
     * constructor
     *
     * @param string    $message Описание ошибки
     * @param string    $code    Код ошибки
     *
     * @see Money_Core::ERR_*
     */
    public function __construct($message, $code = null)
    {
        if ($code) $message = sprintf('%s: %s', $code, $message);
        parent::__construct($message);
        $this->code = $code;
    }
}

/**
 * Cупертип слоя интеграции
 *
 * @package    MailRu_Money
 * @subpackage Core
 *
 * @method mixed get*()
 * @method MailRu_Money_Object set*(mixed $value)
 */
class MailRu_Money_Object  implements Serializable
{
    /**
     * Поля объекта
     * @var array
     */
    private $_data = array();

    /**
     * constructor
     */
    public function __construct()
    {

    }

    /**
     * __get
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return (isset($this->_data[$name]) ? $this->_data[$name] : null);
    }

    /**
     * __set
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        if (!empty($name)) $this->_data[$name] = $value;
    }

    /**
     * __call
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return MailRu_Money_Object|mixed
     * @throws MailRu_Money_Exception
     */
    public function __call($name, $arguments)
    {
        $verb = strtolower(substr($name, 0, 3));
        $field = MailRu_Money_Utils::underscore(substr($name, 3));
        if (in_array($verb, array('get', 'set'))) {
            if ($arguments) {
                $this->$field = (count($arguments) > 1 ? $arguments : array_shift($arguments));
                return $this;
            }
            return $this->$field;
        }
        throw new MailRu_Money_Exception('Method: ' . get_class($this) . '::' . $name . ' doesn\'t exists');
    }

    /**
     * mapField()
     *
     * @return mixed
     */
    protected function mapField()
    {
        $arguments = func_get_args();
        if (($field = MailRu_Money_Utils::camelize(trim(array_shift($arguments))))) {
            if (!$arguments) return call_user_func(array($this, 'get' . $field));
            call_user_func_array(array($this, 'set' . $field), $arguments);
        }
    }

    /**
     * Возвращает значение base64 поля
     *
     * @param string $name Название поля
     *
     * @return string|null
     */
    public function getBase64Field($name)
    {
        return ($this->$name ? MailRu_Money_Utils::base64Decode($this->$name) : null);
    }

    /**
     * Устанавливает значение base64 поля
     *
     * @param string $name
     * @param string $value
     *
     * @return MailRu_Money_Object
     */
    public function setBase64Field($name, $value)
    {
        $this->$name = (!empty($value) ? MailRu_Money_Utils::base64Encode($value) : null);
        return $this;
    }

    /**
     * Импортирует значения из ассоциативного массива используя вызовы методов
     * доступа
     *
     * @param array $data
     *
     * @return MailRu_Money_Object
     */
    public function fromArray(array $data)
    {
        foreach ($data as $field => $value){
            $this->mapField($field, $value);
        }
        return $this;
    }

    /**
     * Преобразовывает в массив
     *
     * @return array
     */
    public function toArray()
    {
        $keys = array_keys($this->_data);
        return array_combine($keys, array_map(array($this, 'mapField'), $keys));
    }

    /**
     * Возвращает массив полей объекта в необработанном виде
     *
     * @return array
     */
    public function getRawData()
    {
        return $this->_data;
    }

    /**
     * Устанавливает массив полей без обработки
     *
     * @param array $data
     *
     * @return MailRu_Money_Object
     */
    public function setRawData(array $data)
    {
        $this->_data = $data;
        return $this;
    }

    /**
     * serialize()
     *
     * @return string
     * @throws MailRu_Money_Exception Если метод не реализован в потомке
     * @see Serializable::serialize()
     */
    public function serialize()
    {
        throw new MailRu_Money_Exception('Serialize method is not implemented');
    }

    /**
     * unserialize()
     *
     * @param string $serialized
     *
     * @return void
     * @throws MailRu_Money_Exception Если метод не реализован в потомке
     * @see Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        throw new MailRu_Money_Exception('Serialize method is not implemented');
    }

}

/**
 * Утилиты
 *
 * @package    MailRu_Money
 * @subpackage Utils
 */
class MailRu_Money_Utils
{
    /**
     * Генерирует цифровую подпись
     *
     * @param array|string $data    Данные для подписи
     * @param string       $key     Ключ для подписи
     * @param string       $algo    Тип цифровой подписи
     * @param boolean      $convert Выполнить преобразования
     *
     * @return string|null
     * @see MailRu_Money::SIGN_TYPE_*
     * @static
     */
    public static function signData($data, $key, $algo = MailRu_Money::SIGN_TYPE_SHA1, $convert = true)
    {
        if (is_array($data)) {
            ksort($data);
            unset($data['signature']);
            $data = join($data);
        }
        if ($convert) $data = mb_convert_encoding($data, 'Windows-1251');
        if (strrpos($algo, MailRu_Money::SIGN_TYPE_SHA1) === (strlen($algo) - 3)) $algo .= 1;
        $algo = strtolower($algo);
        if (($pos = strpos($algo, 'hmac_')) !== false) {
            $algo = substr($algo, $pos + 5);
            if ($algo) return hash_hmac($algo, $data, $key);
        } else {
          echo $data . '<br><br>';
            return hash($algo, $data . $key);
        }
    }

    /**
     * Генерирует цифровую подпись для схемы взаимодействия "Лайт"
     *
     * @param array|string &$data Данные для подписи
     * @param string       $key   Ключ для подписи
     * @param string       $algo  Тип цифровой подписи
     *
     * @return string|null
     * @see MailRu_Money::SIGN_TYPE_*
     * @static
     */
    public static function signLightData(&$data, $key, $algo = MailRu_Money::SIGN_TYPE_SHA1)
    {
        $cryptKey = self::signData($key, '', $algo, false);
        $signature = self::signData($data, $cryptKey, $algo, false);
        if (is_array($data)) $data['signature'] = $signature;
        return $signature;
    }

    /**
     * Кодирует строку в Windows-1251 base64
     *
     * @param string $str
     *
     * @return string
     * @static
     */
    public static function base64Encode($str)
    {
        return base64_encode(mb_convert_encoding($str, 'Windows-1251'));
    }

    /**
     * Декодирует строку из Windows-1251 base64
     *
     * @param string $str
     *
     * @return string
     * @static
     */
    public static function base64Decode($str)
    {
        return mb_convert_encoding(base64_decode($str), mb_internal_encoding(), 'Windows-1251');
    }

    /**
     * Преобразовывает CamelCased в строку нижнего регистра с разделителем "_"
     *
     * @param string $CamelCasedString
     *
     * @return string
     * @static
     */
    public static function underscore($CamelCasedString)
    {
        return preg_replace(
            array('/(?<!^|_)([A-Z][a-z])/', '/([a-z])([A-Z])/', '/([A-Z])([a-z])/e'),
            array('_\\1','\\1_\\2',"strtolower('\\1') . '\\2'"),
            $CamelCasedString
        );
    }

    /**
     * Преобразовывает lower_cased_underscroed_string в CamelCased
     *
     * @param string $lower_cased_underscored_string
     *
     * @return string
     * @static
     */
    public static function camelize($lower_cased_underscored_string)
    {
        return ucfirst(
            preg_replace(
                array('/^(_.)([a-z\d])/e','/(?<!^|_.)_+(.)([a-zA-Z\d])/e'),
                "strtoupper('\\1') . '\\2'",
                $lower_cased_underscored_string
            )
        );
    }
}

/**
 * Gateway Abstract
 *
 * @package    MailRu_Money
 * @subpackage Gateway
 */
abstract class MailRu_Money_Gateway_Abstract
{
    /**
     * context
     * @var MailRu_Money_Core
     */
    protected $context;

    /**
     * Связывает с конкретным инстанциированным объектом MailRu_Money
     *
     * @param MailRu_Money_Core $instance
     *
     * @return MailRu_Money_Gateway_Abstract
     */
    public function bind(MailRu_Money_Core $instance)
    {
        $this->context = $instance;
        return $this;
    }

    /**
     * Возвращает ссылку на связанный объект MailRu_Money
     *
     * @return MailRu_Money
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Выполняет запрос
     *
     * @param MailRu_Money_Request $request
     *
     * @return MailRu_Money_Response
     */
    abstract public function doRequest(MailRu_Money_Request $request);
}

/**
 * Шлюз доступа к программному интерфейсу Деньги@Mail.Ru
 *
 * @package    MailRu_Money
 * @subpackage Gateway
 */
class MailRu_Money_Gateway_Api extends MailRu_Money_Gateway_Abstract
{
    /**
     * Список удаленных методов программного интерфейса Деньги@Mail.Ru
     *
     * Определяет соответствие названий удаленных методов на классы ответа
     *
     * @var array
     *
     * @see MailRu_Money_Gateway_Api::setResponseClass()
     * @see MailRu_Money_Gateway_Api::getResponseClass()
     * @static
     */
    public static $methodsMap = array(
        'invoice.item'  => array('response' => array('class' => 'MailRu_Money_Response_GetInvoice')),
        'info.currency' => array('response' => array('class' => 'MailRu_Money_Response_GetCurrency')),
    );

    /**
     * Устанавливает класс ответа для метода API
     *
     * @param string $method
     * @param string $class
     *
     * @return void
     */
    public static function setMethodResponseClass($method, $class)
    {
        if (!empty($method)) {
            self::$methodsMap[$method]['response']['class'] = $class;
        }
    }

    /**
     * Возвращает класс ответа для метода API
     *
     * @param string $method
     *
     * @return string
     */
    public static function getMethodResponseClass($method)
    {
        return (!empty(self::$methodsMap[$method]['response']['class'])
            ? self::$methodsMap[$method]['response']['class']
            : 'MailRu_Money_Response'
        );
    }

    /**
     * Выполняет запрос
     *
     * @param MailRu_Money_Request $request
     *
     * @return MailRu_Money_Response
     * @throws MailRu_Money_Exception
     * @staticvar array MailRu_Money_Core::$CURL_OPTIONS
     */
    public function doRequest(MailRu_Money_Request $request)
    {
        $curl = curl_init();

        $query = $request->serialize() . '&key=' . urlencode($this->context->getApiKey());
        $method = $request->getMethod();
		$url = MailRu_Money::API_BASE_URI . '/' . str_replace('.', '/', $method);
        curl_setopt_array($curl, MailRu_Money_Core::$CURL_OPTIONS);
        if ($request->getHttpMethod() == 'post') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        } else {
            $url .= '?' . $query;
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        $response = curl_exec($curl);
        $curlInfo = curl_getinfo($curl);
        $responseIsSuccess = ($curlInfo['http_code'] == 200);
        if ($response === false || !$responseIsSuccess) {
            $error = (!$response ? curl_error($curl) : 'Bad response. Http code: ' . $curlInfo['http_code']);
            $errno = (!$response ? curl_errno($curl) : null);
            curl_close($curl);
            throw new MailRu_Money_Exception(
                'CURL request failed with error: ' . $error
                . ($errno ? ' (' . $errno . ')' : '')
            );
        }
        curl_close($curl);

        $responseClass = self::getMethodResponseClass($method);
        $responseObject = new $responseClass($this);
        if (!($responseObject instanceof MailRu_Money_Response)) {
            throw new MailRu_Money_Exception(
                'Parse response error: ' . $responseClass
                . ' is not instance of MailRu_Money_Response'
            );
        }
        $responseObject->unserialize($response);
        return $responseObject;
    }
}

/**
 * Классы запросов к API
 */
/**
 * Базовый класс запроса
 *
 * @package    MailRu_Money
 * @subpackage Request
 */
class MailRu_Money_Request extends MailRu_Money_Object
{
    /**
     * Имя метода программного интерфейса Системы
     * @var string
     */
    protected $method;

    /**
     * http метод
     * @var string
     */
    protected $http_method = 'post';

    /**
     * Возвращает название удаленного метода
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Устанавливает название удаленного метода
     *
     * @param string $name Название удаленного метода
     *
     * @return MailRu_Money_Request;
     */
    public function setMethod($name)
    {
        $this->method = $name;
        return $this;
    }

    /**
     * Устанавливает HTTP метод
     *
     * @param string $httpMethod http метод (get/post)
     *
     * @return MailRu_Money_Request
     */
    public function setHttpMethod($httpMethod)
    {
        $this->http_method = strtolower($httpMethod);
        return $this;
    }

    /**
     * Возвращает тип используемого http метода
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->http_method;
    }

    /**
     * serialize()
     *
     * @return string
     */
    public function serialize()
    {
        return http_build_query($this->getRawData());
    }

    /**
     * unserialize()
     *
     * @param string $serialized
     *
     * @return void
     * @throws MailRu_Money_Exception
     */
    public function unserialize($serialized)
    {
        if (($arUrl = parse_url($serialized)) !== false) {
            $this->setRawData($arUrl['query']);
        } else {
            throw new MailRu_Money_Exception('Cannot unserialize: ' . $serialized);
        }
    }

}

/**
 * Запрос на выставление счета
 *
 * @package MailRu_Money
 * @subpackage Request
 *
 * @method string                           getBuyerEmail()
 * @method MailRu_Money_Request_MakeInvoice setBuyerEmail(string $buyerEmail)
 * Адрес зарегистрированного пользователя Системы
 *
 * @method string                           getCurrency()
 * @method MailRu_Money_Request_MakeInvoice setCurrency(string $currency)
 * Код валюты счета (RUR)
 *
 * @method string                           getBuyerIp()
 * @method MailRu_Money_Request_MakeInvoice setBuyerIp(string $buyerIp)
 * IP-адрес покупателя, которому будет выставлен счет
 *
 * @method integer|null                     getValidDays()
 * @method MailRu_Money_Request_MakeInvoice setValidDays(integer $validDays)
 * Максимальное количество дней с момента выставления счета, в течение которых
 * можно его оплатить. Если параметр не указан, оплатить счет можно в течение
 * любого времени
 *
 * @method boolean|null                     getKeepUniq()
 * @method MailRu_Money_Request_MakeInvoice setKeepUniq(boolean $keepUniq)
 * Поддерживать уникальность кода заказа. Если параметр указан, создание
 * новых счетов с таким же issuer_id будет запрещено, а при попытке выставить
 * повторный счет будет получена ошибка. Параметр игнорируется, если не указан
 * issuer_id
 */
class MailRu_Money_Request_MakeInvoice extends MailRu_Money_Request
{
    protected $method = 'invoice.make';

    /**
     * constructor
     *
     * @param string  $buyerEmail
     * @param decimal $amount
     * @param string  $currency
     * @param string  $description
     * @param string  $buyerIp
     * @param string  $issuerId
     *
     * @see MailRu_Money::makeInvoice
     */
    public function __construct($buyerEmail, $amount, $currency, $description, $buyerIp, $issuerId = null)
    {
        parent::__construct();
        $this->setBuyerEmail($buyerEmail)
             ->setCurrency($currency)
             ->setAmount($amount)
             ->setDescription($description)
             ->setBuyerIp($buyerIp)
             ->setIssuerId($issuerId);
    }

    /**
     * getAmount()
     *
     * @return decimal
     */
    public function getAmount()
    {
        return $this->getSum();
    }

    /**
     * Cумма счета
     *
     * @param decimal $amount
     *
     * @return MailRu_Money_Request_MakeInvoice
     */
    public function setAmount($amount)
    {
        return $this->setSum($amount);
    }

    /**
     * getDescription()
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getBase64Field('description');
    }

    /**
     * Назначение платежа по счету
     *
     * @param string $description
     *
     * @return MailRu_Money_Request_MakeInvoice
     */
    public function setDescription($description)
    {
        return $this->setBase64Field('description', $description);
    }

    /**
     * getIssuerId()
     *
     * @return string|null
     */
    public function getIssuerId()
    {
        return $this->getBase64Field('issuer_id');
    }

    /**
     * Уникальный код заказа по системе отправителя счета. Может использоваться
     * для определения факта оплаты счета.
     *
     * @param string $issuerId
     *
     * @return MailRu_Money_Request_MakeInvoice
     */
    public function setIssuerId($issuerId)
    {
        $this->setBase64Field('issuer_id', $issuerId);
        return $this;
    }

    /**
     * getMessage()
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getBase64Fields('message');
    }

    /**
     * Дополнительная информация о платеже
     *
     * @param string $message
     *
     * @return MailRu_Money_Request_MakeInvoice
     */
    public function setMessage($message)
    {
        return $this->setBase64Field('message', $message);
    }

    /**
     * Срок действия счета в формате Y-m-d H:i:s
     *
     * @return string|null
     */
    public function getValidTime()
    {
        return ($this->valid_time
            ? date('Y-m-d H:i:s', strtotime($this->valid_time))
            : null
        );
    }

    /**
     * Cрок действия счета, установленный в виде точного времени
     *
     * @param string $time Точное время в любом формате поддерживаемом strtotime()
     *
     * @return MailRu_Money_Request_MakeInvoice
     */
    public function setValidTime($time)
    {
        $this->valid_time = date('YmdHis', strtotime($time));
        return $this;
    }
}

/**
 * Запрос на получение статуса счета
 *
 * @package    MailRu_Money
 * @subpackage Request
 *
 * @method string                          getInvoiceNumber()
 * @method MailRu_Money_Request_GetInvoice setInvoiceNumber(string $invoiceNumber)
 * Номер счета для которого проверяется статус. Предполагается, что счет был
 * выставлен ранее
 */
class MailRu_Money_Request_GetInvoice extends MailRu_Money_Request
{
    protected $method = 'invoice.item';

    /**
     *  construnctor
     *
     * @param string $invoiceNumber
     * @param string $issuerId
     *
     * @see MailRu_Money::getInvoice
     */
    public function __construct($invoiceNumber, $issuerId = null)
    {
        parent::__construct();
        $this->setInvoiceNumber($invoiceNumber)
             ->setIssuerId($issuerId);
    }

    /**
     * getIssuerId()
     *
     * @return string|null
     */
    public function getIssuerId()
    {
        return $this->getBase64Field('issuer_id');
    }

    /**
     * Код заказа по системе отправителя счета
     *
     * @param string $issuerId
     *
     * @return MailRu_Money_Request_GetInvoice
     */
    public function setIssuerId($issuerId)
    {
        return $this->setBase64Field('issuer_id', $issuerId);
    }
}

/**
 * Классы ответов API
 */
/**
 * Базовый класс ответа
 *
 * @package    MailRu_Money
 * @subpackage Response
 */
class MailRu_Money_Response extends MailRu_Money_Object
{
    /**
     * Gateway
     * @var MailRu_Money_Gateway_Abstract
     */
    protected $gateway;

    /**
     * constructor
     *
     * @param MailRu_Money_Gateway_Abstract $gateway
     */
    public function __construct(MailRu_Money_Gateway_Abstract $gateway)
    {
        $this->gateway = $gateway;
        parent::__construct();
    }

    /**
     * serialize()
     *
     * @return string
     */
    public function serialize()
    {
        return json_encode($this->getRawData());
    }

    /**
     * unserialize()
     *
     * @param string $serialized
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        $data = json_decode($serialized, true);
        $internalEncoding = mb_internal_encoding();
        array_walk_recursive(
            $data,
            create_function(
                '&$val',
                '$val = mb_convert_encoding($val, \'' . $internalEncoding . '\', \'UTF-8\');'
            )
        );

        if (!empty($data['errorcode'])) {
            throw new MailRu_Money_Api_Exception($data['errormsg'], $data['errorcode']);
        }
        if (empty($data['result'])) {
            throw new MailRu_Money_Api_Exception('Empty response');
        }
        if (isset($data['result']) && is_array($data['result'])) {
            $data = $data['result'];
        }
        $this->setRawData($data);
    }

}

/**
 * Ответ Системы, содержащий информацию о счете
 *
 * @package    MailRu_Money
 * @subpackage Response
 *
 * @method string       getInvoice()        Номер счета
 *
 * @method string       getStatus()
 * Статус счета:
 * - NEW: новый счет
 * - REJECTED: получатель отказался от оплаты счета
 * - PAID: счет оплачен
 * - EXPIRED: срок действия счета истек
 * - DELIVERED: счет доставлен получателю, можно отправить на страницу оплаты
 *
 * @method string       getCurrency()       Код валюты счета
 *
 * @method string       getPayer()          Получатель счета (адрес e-mail)
 *
 * @method string|null  getPayment()        Номер платежа (если счет оплачен)
 *
 * @method decimal      getAmount()         Сумма счета
 *
 * @method decimal|null getPaidAmount()     Сумма, оплаченная получателем счета
 * (если счет оплачен)
 *
 * @method decimal|null getPaidTotal()      Сумма, списанная с получателя счета
 *
 * @method string       getUrlPay()         URL, на который необходимо отправлять
 * для оплаты счета
 *
 * @method integer      getIssueTimestamp() timestamp выставления счета
 *
 * @method integer|null getPaidTimestamp()  timestamp оплаты счета
 *
 * @method integer|null getValidTimestamp() timestamp даты окончания срока
 * действия счета
 *
 * @method string       getSignature()
 * Цифровая сигнатура всего ответа Системы, подписанная ключом Системы.
 * Используется для урегулирования в случае возникновения претензий со стороны
 * отправителя счета
 */
class MailRu_Money_Response_GetInvoice extends MailRu_Money_Response
{
    /**
     * Назначение платежа по счету
     *
     * @return string
     */
    public function getReason()
    {
        return $this->getBase64Field('reason');
    }

    /**
     * Дополнительная информация о платеже
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getBase64Field('message');
    }

    /**
     * Код заказа по системе отправителя счета
     *
     * Устанавливается отправителем в момент выставления счета
     *
     * @return string|null
     */
    public function getIssuerId()
    {
        return $this->getBase64Field('issuer_id');
    }

    /**
     * Дата выставления счета в формате: Y-m-d H:i:s
     *
     * @return string
     */
    public function getIssueDate()
    {
        return ($this->issue_timestamp
            ? date('Y-m-d H:i:s', $this->issue_timestamp)
            : null
        );
    }

    /**
     * Cрок действия счета, в случае, он был установлен при создании счета
     * в формате: Y-m-d H:i:s
     *
     * @return string|null
     */
    public function getValidDate()
    {
        return ($this->valid_timestamp
            ? date('Y-m-d H:i:s', $this->valid_timestamp)
            : null
        );
    }

    /**
     * Дата оплаты счета в формате: Y-m-d H:i:s
     *
     * @return string|null
     */
    public function getPaidDate()
    {
        return ($this->paid_timestamp
            ? date('Y-m-d H:i:s', $this->paid_timestamp)
            : null
        );
    }
}

/**
 * Ответ Системы со списком валют
 *
 * @package    MailRu_Money
 * @subpackage Response
 *
 */
class MailRu_Money_Response_GetCurrency extends MailRu_Money_Response
{
    /**
     * setRawData()
     *
     * @param array $data
     *
     * @return MailRu_Money_Response_GetCurrency
     * @see MailRu_Money_Object::setRawData()
     */
    public function setRawData(array $data)
    {
        $arData = array();
        foreach ($data as $item) {
            if (empty($item['currency'])) continue;
            $arData[$item['currency']] = $item;
        }
        parent::setRawData($arData);
    }

    /**
     * getRawData()
     *
     * @return array
     * @see MailRu_Money_Object::getRawData()
     */
    public function getRawData()
    {
        return array_values(parent::getRawData());
    }
}
