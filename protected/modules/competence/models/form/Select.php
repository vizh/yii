<?php
namespace competence\models\form;

use competence\models\form\attribute\CheckboxValue;
use competence\models\Result;

/**
 * Class Select allows to choose only one answer from select box
 *
 * @property CheckboxValue[] $Values
 *
 */
class Select extends Base
{
    /**
     * @var array Values
     */
    public $value;

    /**
     * @var string Other value
     */
    public $other;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [];
        $rules[] = $this->question->Required ?
            ['value', 'required', 'message' => \Yii::t('app', 'Выберите один ответ из списка')] :
            ['value', 'safe'];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function processAdminPanel()
    {
        parent::processAdminPanel();

        $multiple = \Yii::app()->getRequest()->getParam('Multiple');

        /** @var CheckboxValue[] $values */
        $values = [];

        $maxSort = 0;
        foreach ($multiple as $key => $row) {
            if (empty($row['key']) && empty($row['title'])) {
                continue;
            }

            $values[] = new CheckboxValue(
                $row['key'],
                $row['title'],
                isset($row['isOther']),
                (int)$row['sort'],
                isset($row['isUnchecker']),
                $row['description']
            );
            $maxSort = max((int)$row['sort'], $maxSort);
        }

        foreach ($values as $value) {
            if ($value->sort > 0) {
                continue;
            }

            $maxSort += 10;
            $value->sort = $maxSort;
        }
        usort($values, function ($a, $b) {
            return $a->sort < $b->sort ? -1 : 1;
        });

        foreach ($values as $key => $value) {
            if (empty($value->key)) {
                $this->question->addError('Title', 'Строка '.($key + 1).': не задан ключ для варианта ответа');
            }
        }

        $this->question->setFormData(['Values' => $values]);
    }

    /**
     * @inheritdoc
     */
    public function getInternalExportValueTitles()
    {
        $titles = [];
        foreach ($this->Values as $value) {
            $titles[] = $value->title;
        }

        $titles[] = 'Свое значение';

        return $titles;
    }

    /**
     * @inheritdoc
     */
    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];

        foreach ($this->Values as $value) {
            $data[] = !empty($questionData) && in_array($value->key, $questionData['value']) ? 1 : 0;
        }

        $data[] = !empty($questionData) ? $questionData['other'] : '';

        return $data;
    }

    /**
     * @inheritdoc
     */
    protected function getFormData()
    {
        return ['value' => $this->value, 'other' => $this->other];
    }

    /**
     * @inheritdoc
     */
    protected function getFormAttributeNames()
    {
        return ['Values'];
    }

    /**
     * @inheritdoc
     */
    protected function getDefinedViewPath()
    {
        return 'competence.views.form.select';
    }

    /**
     * @inheritdoc
     */
    public function getAdminView()
    {
        return 'competence.views.form.admin.select';
    }
}
