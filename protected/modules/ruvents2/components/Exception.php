<?php
namespace ruvents2\components;

class Exception extends \CException
{
    /**
     * 100 - 199: общие ошибки работы с api: авторизации, параметры
     * 200 - 299: ошибки работы с Participants
     * 300 - 399: ошибки работы с Badges
     * 400 - 499: ошибки работы с OrderItems и Products
     */
    const ACCESS_DENIED = 101;
    const INVALID_HASH = 102;
    const INVALID_OPERATOR_ID = 103;
    const INVALID_OPERATOR_EVENT = 104;
    const INVALID_PARAM = 110;
    const INVALID_PARAMS = 111;
    const INVALID_ROLE_ID = 112;
    const INVALID_PART_ID = 113;
    const INVALID_CHECK_TIME = 121;
    const INVALID_PRODUCT_ID = 131;
    const INVALID_HALL_ID = 141;

    const NEW_PARTICIPANT_EMPTY_STATUS = 201;
    const INVALID_PARTICIPANT_ID = 202;

    const INVALID_PART_ID_FOR_BADGE = 301;

    /**
     * Возвращает массив трансляции сообщений
     * @return array
     */
    protected static function getMessages()
    {
        return [
            static::ACCESS_DENIED => 'Недостаточно прав доступа к ресурсу',
            static::INVALID_HASH => 'Неверный Hash доступа к API',
            static::INVALID_OPERATOR_ID => 'Не найден оператор с Id %s',
            static::INVALID_OPERATOR_EVENT => 'Оператор с Id %s относится к другому мероприятию',
            static::INVALID_PARAM => 'Задан неверный параметр %s = %s',
            static::INVALID_PARAMS => 'Неверно заданы следующие параметры: %s',
            static::INVALID_ROLE_ID => 'Не найдена роль с ID: %s',
            static::INVALID_PART_ID => 'Не найдена часть с ID: %s',
            static::INVALID_PRODUCT_ID => 'Не найден товар с ID: %s',
            static::INVALID_HALL_ID => 'Не найден зал с ID: %s',

            static::NEW_PARTICIPANT_EMPTY_STATUS => 'Для нового участника статус на мероприятии не может быть пустым',
            static::INVALID_PARTICIPANT_ID => 'Не найден участник с ID: %s',

            static::INVALID_PART_ID_FOR_BADGE => 'Пользователь %s не является участником части мероприятия %s'
        ];
    }

    /**
     * Возвращает сообщение об ошибке
     *
     * @param      $code
     * @param null $params
     * @return mixed
     */
    public static function getCodeMessage($code, $params = null)
    {
        return $params === null
            ? self::getMessages()[$code]
            : vsprintf(self::getMessages()[$code], $params);
    }

    /**
     * Генерирует исключение при неверном параметре
     * @param string|array $paramName
     * @param string $message
     * @return Exception
     */
    public static function createInvalidParam($paramName, $message = '')
    {
        return is_array($paramName)
            ? new self(static::INVALID_PARAMS, implode(', ', $paramName))
            : new self(static::INVALID_PARAM, [$paramName, $message]);
    }

    public function __construct($code, $params = [], Exception $previous = null)
    {
        parent::__construct($this->getErrorMessage($code, $params), $code, $previous);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Ruvents2 Exception';
    }

    /**
     * Возвращает текст сообщения исключения
     * @param mixed $code
     * @param array $params
     * @return string
     */
    private function getErrorMessage($code, $params)
    {
        if (array_key_exists($code, self::getMessages()))
            return self::getCodeMessage($code, $params);

        return $this->getName();
    }

    public function render()
    {
        http_response_code(500);
        header('Content-type: application/json; charset=utf-8');

        $error = [
            'Code' => $this->getCode(),
            'Message' => $this->getMessage()
        ];

        echo json_encode(['Error' => $error], JSON_UNESCAPED_UNICODE);
    }
}