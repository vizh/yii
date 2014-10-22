<?php
namespace competence\models\form;

use competence\models\Result;

/**
 * Class Multiple
 * @package competence\models\form
 *
 * @property \competence\models\form\attribute\CheckboxValue[] $Values
 */
class Multiple extends \competence\models\form\Base
{
  public $other;

  protected function getFormData()
  {
    return ['value' => $this->value, 'other' => $this->other];
  }

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Необходимо выбрать хотя бы один ответ из списка'],
      ['other', 'checkOtherValidator'],
    ];
  }

  public $value = [];

  public function checkOtherValidator($attribute, $params)
  {
    foreach ($this->Values as $value)
    {
      if (!in_array($value->key, $this->value) || !$value->isOther)
        continue;
      $this->other = trim($this->other);

      if (empty($this->other))
      {
        $this->addError('', 'Необходимо заполнить текстовое поле "другое"');
        return false;
      }
    }
    return true;
  }


  protected function getFormAttributeNames()
  {
    return ['Values'];
  }

  protected function getDefinedViewPath()
  {
    return 'competence.views.form.multiple';
  }

  public function getAdminView()
  {
    return 'competence.views.form.admin.multiple';
  }

  public function processAdminPanel()
  {
    parent::processAdminPanel();

    $multiple = \Yii::app()->getRequest()->getParam('Multiple');
    /** @var \competence\models\form\attribute\CheckboxValue[] $values */
    $values = [];
    $maxSort = 0;
    foreach ($multiple as $key => $row)
    {
      if (empty($row['key']) && empty($row['title']))
        continue;

      $values[] = new \competence\models\form\attribute\CheckboxValue($row['key'], $row['title'], isset($row['isOther']), (int)$row['sort'], isset($row['isUnchecker']), $row['description'], $row['suffix']);
      $maxSort = max((int)$row['sort'], $maxSort);
    }

    foreach ($values as $value)
    {
      if ($value->sort > 0)
        continue;
      $maxSort += 10;
      $value->sort = $maxSort;
    }
    usort($values, function($a, $b) {return $a->sort < $b->sort ? -1 : 1;});

    foreach ($values as $key => $value)
    {
      if (empty($value->key))
      {
        $this->question->addError('Title', 'Строка ' . ($key+1) . ': не задан ключ для варианта ответа');
      }
    }

    $this->question->setFormData(['Values' => $values]);
  }

    public function getInternalExportValueTitles()
    {
        $titles = [];
        foreach ($this->Values as $value) {
            $titles[] = $value->title;
        }
        $titles[] = 'Свое значение';
        return $titles;
    }

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
}