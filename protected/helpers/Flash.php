<?php
namespace application\helpers;

/**
 * Class Flash
 *
 * Flash Хелпер
 * @package application\helpers
 */
class Flash
{
    const SUCCESS = 'success';
    const WARNING = 'warning';
    const INFO = 'info';
    const ERROR = 'error';

    /**
     * @param string $message
     */
    public static function setSuccess($message)
    {
        \Yii::app()->getUser()->setFlash(self::SUCCESS, $message);
    }

    /**
     * @param string $message
     */
    public static function setWarning($message)
    {
        \Yii::app()->getUser()->setFlash(self::WARNING, $message);
    }

    /**
     * @param string $message
     */
    public static function setInfo($message)
    {
        \Yii::app()->getUser()->setFlash(self::INFO, $message);
    }

    /**
     * @param string|\Exception $message
     */
    public static function setError($message)
    {
        if ($message instanceof \Exception) {
            $message = YII_DEBUG ? $message->getMessage() : 'Возникла внутренняя ошибка';
        }
        \Yii::app()->getUser()->setFlash(self::ERROR, $message);
    }

    /**
     * Проверяет наличие флеш сообщения по ключу - определенным константам, например self::FLASH_SUCCESS
     * @param String $key
     * @return bool
     */
    public static function hasFlash($key)
    {
        return \Yii::app()->getUser()->hasFlash($key);
    }

    /**
     * Позвращает флеш сообщение по заданному ключу, например self::FLASH_SUCCESS
     * @param string $key
     * @return mixed
     */
    public static function getFlash($key)
    {
        return \Yii::app()->getUser()->getFlash($key);
    }

    /**
     * Возвращает контейнер для содержимого
     * @param string $content
     * @param string $typeClass
     * @return string
     */
    private static function htmlContainer($content, $typeClass)
    {
        if (empty($content)) {
            return '';
        }

        $options = ['class' => ('alert alert-dismissible fade in '.$typeClass), 'role' => 'alert'];
        return \CHtml::tag('div', $options, $content);
    }

    /**
     * Возвращает html представление для флеш сообщения с ключем success
     * @param string $typeClass
     * @return string
     */
    public static function success($typeClass = 'alert-success')
    {
        return self::htmlContainer(self::getFlash(self::SUCCESS), $typeClass);
    }

    /**
     * Возвращает html представление для флеш сообщения с ключем warning
     * @param string $typeClass
     * @return string
     */
    public static function warning($typeClass = 'alert-warning')
    {
        return self::htmlContainer(self::getFlash(self::WARNING), $typeClass);
    }

    /**
     * Возвращает html представление для флеш сообщения с ключем info
     * @param string $typeClass
     * @return string
     */
    public static function info($typeClass = 'alert-danger')
    {
        return self::htmlContainer(self::getFlash(self::INFO), $typeClass);
    }

    /**
     * Возвращает html представление для флеш сообщения с ключем error
     * @param string $typeClass
     * @return string
     */
    public static function error($typeClass = 'alert-danger')
    {
        return self::htmlContainer(self::getFlash(self::ERROR), $typeClass);
    }

    /**
     * Возвращает html представление для флеш сообщений
     * @return string
     */
    public static function html()
    {
        return self::success().self::warning().self::info().self::error();
    }
}