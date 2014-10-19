<?php
namespace pay\components;

class CodeException extends Exception
{
    /**
     * @param int $code
     * @param array $params
     * @param \Exception $previous
     */
    public function __construct($code, $params = [], \Exception $previous = null)
    {
        parent::__construct($this->getErrorMessage($code, $params), $code, $previous);
    }

    const NO_PAY_ACCOUNT = 101;


    const NO_PRODUCT_FOR_COUPON_100 = 303;
    const WRONG_PRODUCT_FOR_COUPON_100 = 304;

    private $codes = [
        /** Yii Exception */
        0 => /*'Обработана ошибка Yii: */'%s',

        /** Общие ошибки */
        self::NO_PAY_ACCOUNT => 'Для мероприятия %s,%s,%s не определен платежный аккаунт',



        /** Ошибки Order */
        201 => 'Оплачен неизвестный заказ номер %s',
        202 => 'Сумма заказа и полученная через платежную систему не совпадают',
        203 => 'Один или несколько товаров имеют более ценный эквивалент среди уже приобретенных пользователем. Список id: %s',
        204 => 'Заказ № %s уже оплачен',

        /** Ошибки промо-кодов */
        301 => 'Превышено максимальное количество активаций промо кода',
        302 => 'У пользователя уже активирован промо код с большей скидкой',
        self::NO_PRODUCT_FOR_COUPON_100 => 'Для промо кода со скидкой 100% не указан товар, на который распространяется скидка',
        self::WRONG_PRODUCT_FOR_COUPON_100 => 'Данный промо-код не может быть активирован для выбранного товара',
        305 => 'Срок действия вашего промо кода истек',


        /** Ошибки OrderItem */
        401 => 'Данный товар не может быть приобретен этим пользователем. Возможно уже куплен этот или аналогичный товар',






        /** Ошибки платежных систем */
        901 => 'Ошибка при вычислении хеша',
        902 => 'Не найдено мероприятие с идентификатором %s',
        903 => 'Не корректный статус платежа %s',





    ];

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
} 