<?php

namespace ruvents2\models\forms;

use ruvents2\components\Exception;
use ruvents2\components\form\RequestForm;
use Yii;

class ParticipantListRequest extends RequestForm
{
    public $since;
    public $limit;
    public $Fount;

    public function rules()
    {
        return [
            ['limit', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => Yii::app()->params['RuventsMaxResults']],
            ['limit', 'default', 'value' => Yii::app()->params['RuventsMaxResults']],
            ['since', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss', 'allowEmpty' => true],
            ['Fount', 'validateFount']
        ];
    }

    public function validateFount($attribute)
    {
        if ($this->Fount !== null) {
            $this->Fount = filter_var($this->Fount, FILTER_SANITIZE_STRING);

            /* Правильный Fount - восьмисимвольный */
            if (strlen($this->Fount) !== 32) {
                $this->addError($attribute, Exception::getCodeMessage(Exception::INVALID_PARAM, [$attribute, $this->Fount]));
            }

            /* Нам не нужен Fount при отсутствующем или невалидном кеше */
            if (Yii::app()->getCache()->get('excerpt:participants:'.$this->Fount) === false) {
                Yii::app()->getCache()->delete('excerpt:participants:'.$this->Fount); // toDo: А это вообще надо? Кеш очищается автоматически?
                $this->Fount = null;
            }
        }
    }
}