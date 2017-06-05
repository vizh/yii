<?php

namespace ruvents2\components\form;

use application\components\helpers\ArrayHelper;
use ruvents2\components\Exception;
use Yii;

class RequestForm extends \CFormModel
{
    public function __construct($scenario = '')
    {
        /* Инициализация формы в штатном режиме */
        parent::__construct($scenario);

        /* Автозагрузка значений формы. Пока берём совершенно все параметры
         * запроса, не важно каким образом они были переданы. Возможно, в дальнейшем
         * потребуется уточнение. Или дополнительные шаманства. Например, забрать
         * только $this->getAttributes() */
        $this->attributes = array_filter(array_merge($_REQUEST, Yii::app()->getRequest()->getRestParams()), 'trim');

        /* И сразу же, дабы упростить использование, валидируем. */
        if ($this->validate() === false) {
            throw new Exception(Exception::INVALID_PARAMS, ArrayHelper::each($this->errors, function ($value, $key) {
                return sprintf("[%s] %s", $key, implode(', ', $value));
            }));
        }
    }
}