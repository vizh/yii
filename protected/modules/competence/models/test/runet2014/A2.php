<?php
namespace competence\models\test\runet2014;

use user\models\User;

class A2 extends \competence\models\form\Input
{
    public function __construct($question, $scenario = '')
    {
        parent::__construct($question, $scenario);
        if (empty($this->value)) {
            /** @var User $user */
            $user = \Yii::app()->getUser()->getCurrentUser();
            if (!empty($user->Birthday)) {
                $this->value = \Yii::app()->getDateFormatter()->format('dd.MM.yyyy', $user->Birthday);
            }
        }
    }


    public function rules()
    {
        return array_merge(parent::rules(), [
            ['value', 'date', 'format' => 'dd.MM.yyyy', 'message' => 'Неправильный формат ответа на вопрос. Укажите дату в формате день.месяц.год']
        ]);
    }

}
