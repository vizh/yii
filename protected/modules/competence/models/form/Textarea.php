<?php
namespace competence\models\form;

use competence\models\Result;

/**
 * Class Textarea
 * @package competence\models\form
 *
 * @property boolean $Required
 */
class Textarea extends Base
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
        return ['Required'];
    }

    protected function getDefinedViewPath()
    {
        return 'competence.views.form.textarea';
    }


    public function getAdminView()
    {
        return 'competence.views.form.admin.textarea';
    }

    public function attributeLabels()
    {
        return [
            'Required' => 'Обязательно для заполнения'
        ];
    }


    public function processAdminPanel()
    {
        parent::processAdminPanel();
        $attributes = \Yii::app()->getRequest()->getParam(get_class($this));
        $data = [];
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