<?php
namespace application\components;

use application\components\helpers\ArrayHelper;
use Yii;

class Exception extends \CException
{
    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        // Передана модель с ошибками валидации
        if ($message instanceof ActiveRecord) {
            if ($code === 0) {
                $code = 500;
            }
            /** @var \CModel $message */
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                $message = json_encode([
                    'Error' => [
                        'Code' => $code,
                        'Message' => 'Ошибки валидации при сохранении модели',
                        'Fields' => $message->getErrors()
                    ]
                ], JSON_UNESCAPED_UNICODE);
            } else {
                $message = sprintf("Ошибки валидации при сохранении модели:\n&mdash; %s",
                    implode("\n&mdash; ", ArrayHelper::straighten($message->getErrors()))
                );
            }
        }
        // Далее действуем штатно
        parent::__construct($message, $code, $previous);
    }
}
