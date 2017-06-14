<?php
namespace application\components;

use application\components\helpers\ArrayHelper;

class Exception extends \CException
{
    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        // Передана модель с ошибками валидации
        if ($message instanceof ActiveRecord) {
            /** @var \CModel $message */
            $message = sprintf("Ошибки валидации при сохранении модели:\n&mdash; %s",
                implode("\n&mdash; ", ArrayHelper::straighten($message->getErrors()))
            );
        }
        // Далее действуем штатно
        parent::__construct($message, $code, $previous);
    }
}
