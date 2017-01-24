<?php
namespace competence\models\form;

use competence\models\Result;

/**
 * Class Input
 *
 * @property string $Suffix
 * @property bool $Required
 *
 */
class Input extends Base
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [];
        if ($this->Required || $this->Required === null) {
            $rules[] = ['value', 'required', 'message' => \Yii::t('app', 'Введите в строке ответ на вопрос')];
        }
        return $rules;
    }

    /**
     * @inheritdoc
     */
    protected function getFormAttributeNames()
    {
        return ['Suffix', 'Required'];
    }

    /**
     * @inheritdoc
     */
    protected function getDefinedViewPath()
    {
        return 'competence.views.form.input';
    }

    /**
     * @inheritdoc
     */
    public function getAdminView()
    {
        return 'competence.views.form.admin.input';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Suffix' => 'Суффикс к строке ввода',
            'Required' => 'Обязательно для заполнения'
        ];
    }

    /**
     * @inheritdoc
     */
    public function processAdminPanel()
    {
        parent::processAdminPanel();

        $attributes = \Yii::app()->getRequest()->getParam(get_class($this));
        $data = [];
        $data['Suffix'] = !empty($attributes['Suffix']) ? $attributes['Suffix'] : null;
        $data['Required'] = isset($attributes['Required']) ? (boolean)$attributes['Required'] : false;

        $this->question->setFormData($data);
    }

    /**
     * @inheritdoc
     */
    public function getInternalExportValueTitles()
    {
        return ['Ответ'];
    }

    /**
     * @inheritdoc
     */
    public function getInternalExportData(Result $result)
    {
        $data = $result->getQuestionResult($this->question);
        return !empty($data) ? [$data['value']] : [''];
    }
}
