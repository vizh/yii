<?php

namespace ruvents2\components;

use application\components\helpers\ArrayHelper;

class FormModel extends \CFormModel
{
    public function __construct($scenario = '')
    {
        /* Инициализация формы в штатном режиме */
        parent::__construct($scenario);

        /* Автозагрузка значений формы. Пока берём совершенно все параметры
         * запроса, не важно каким образом они были переданы. Возможно, в дальнейшем
         * потребуется уточнение. Или дополнительные шаманства. Например, забрать
         * только $this->getAttributes() */
        $this->attributes = $_REQUEST;

        /* И сразу же, дабы упростить использование, валидируем. */
        if ($this->validate() === false) {
            throw new Exception(Exception::INVALID_PARAMS, ArrayHelper::each($this->errors, function($value, $key){
                return sprintf("[%s] %s", $key, implode(', ', $value));
            }));
        }
    }
}