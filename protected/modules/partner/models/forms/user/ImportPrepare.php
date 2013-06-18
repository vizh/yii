<?php
namespace partner\models\forms\user;


class ImportPrepare extends \CFormModel
{
  public $field_0;
  public $field_1;
  public $field_2;
  public $field_3;
  public $field_4;
  public $field_5;
  public $field_6;
  public $field_7;
  public $field_8;
  public $field_9;

  public $Notify = false;
  public $NotifyEvent = false;
  public $Visible = false;


  public $Submit;

  public function rules()
  {
    return [
      ['Submit', 'required'],
      ['field_0, field_1, field_2, field_3, field_4, field_5, field_6, field_7, field_8, field_9, Notify, Hide', 'safe']
    ];
  }

  private $fieldNames = [
    '' => 'Выбрать',
    'LastName' => 'Фамилия',
    'FirstName' => 'Имя',
    'FatherName' => 'Отчество',
    'Email' => 'Email',
    'Phone' => 'Телефон',
    'Company' => 'Компания',
    'Position' => 'Должность',
    'Role' => 'Статус',
  ];

  public function getFieldNames()
  {
    return $this->fieldNames;
  }

  private $fields = [
    'field_0' => 0,
    'field_1' => 1,
    'field_2' => 2,
    'field_3' => 3,
    'field_4' => 4,
    'field_5' => 5,
    'field_6' => 6,
    'field_7' => 7,
    'field_8' => 8,
    'field_9' => 9
  ];

  public function getFields()
  {
    return $this->fields;
  }

  public function attributeLabels()
  {
    return [
      'field_0' => 'Столбец 1',
      'field_1' => 'Столбец 2',
      'field_2' => 'Столбец 3',
      'field_3' => 'Столбец 4',
      'field_4' => 'Столбец 5',
      'field_5' => 'Столбец 6',
      'field_6' => 'Столбец 7',
      'field_7' => 'Столбец 8',
      'field_8' => 'Столбец 9',
      'field_9' => 'Столбец 10'
    ];
  }

  public function checkActiveFields($actives)
  {
    foreach ($this->fields as $key => $value)
    {
      if (in_array($value, $actives) && (empty($this->$key) || !isset($this->fieldNames[$this->$key])))
      {
        $this->addError($key, 'Не выбрано соответствие всех столбцов и полей с данными');
        return false;
      }
    }
    return true;
  }


}