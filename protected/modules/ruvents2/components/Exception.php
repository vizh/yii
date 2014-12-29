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

    /**
     * Генерирует исключение при неверном параметре
     * @param $paramName
     * @return Exception
     */
    public static function createInvalidParam($paramName)
    {
        return new self(static::INVALID_PARAM, [$paramName]);
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
     * Возвращает массив трансляции сообщений
     * @return array
     */
    protected function getMessages()
    {
        return [
            static::ACCESS_DENIED => 'Недостаточно прав доступа к ресурсу',
            static::INVALID_HASH => 'Неверный Hash доступа к API',
            static::INVALID_OPERATOR_ID => 'Не найден оператор с Id %s',
            static::INVALID_OPERATOR_EVENT => 'Оператор с Id %s относится к другому мероприятию',
            static::INVALID_PARAM => 'Задан неверный параметр %s'
        ];
    }

    /**
     * Возвращает текст сообщения исключения
     * @param mixed $code
     * @param array $params
     * @return string
     */
    private function getErrorMessage($code, $params)
    {
        $messages = $this->getMessages();
        if (array_key_exists($code, $messages)) {
            return call_user_func_array('sprintf', array_merge([$messages[$code]], $params));
        }

        return $this->getName();
    }

    public function render()
    {
        http_response_code(400);
        header('Content-type: application/json; charset=utf-8');

        $error = new \stdClass();
        $error->Code = $this->getCode();
        $error->Message = $this->getMessage();

        echo json_encode(['Error' => $error], JSON_UNESCAPED_UNICODE);
    }
}