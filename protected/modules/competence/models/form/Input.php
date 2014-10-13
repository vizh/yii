<?php
namespace competence\models\form;

use competence\models\Result;

/**
 * Class Input
 * @package competence\models\form
 *
 * @property string $Suffix
 * @property boolean $Required
 */
class Input extends Base
{
    public function rules()
    {
        $rules = [];
        if ($this->Required || $this->Required === null) {
            $rules[] = ['value', 'required', 'message' => 'Введите в строке ответ на вопрос'];
        }
        return $rules;
    }

    protected function getFormAttributeNames()
    {
        return ['Suffix', 'Required'];
    }


    protected function getDefinedViewPath()
    {
        return 'competence.views.form.input';
    }

    public function getAdminView()
    {
        return 'competence.views.form.admin.input';
    }

    public function attributeLabels()
    {
        return [
            'Suffix' => 'Суффикс к строке ввода',
            'Required' => 'Обязательно для заполнения'
        ];
    }


    public function processAdminPanel()
    {
        parent::processAdminPanel();
        $attributes = \Yii::app()->getRequest()->getParam(get_class($this));
        $data = [];
        $data['Suffix'] = !empty($attributes['Suffix']) ? $attributes['Suffix'] : null;
        $data['Required'] = isset($attributes['Required']) ? (boolean)$attributes['Required'] : false;
        $this->question->setFormData($data);
    }

    public function getInternalExportValueTitles()
    {
        return ['Ответ'];
    }

    public function getInternalExportData(Result $result)
    {
        $data = $result->getQuestionResult($this->question);
        return !empty($data) ? [$data['value']] : [''];
    }
}