<?php
namespace contact\models\forms;

class Phone extends \CFormModel
{
  const ScenarioOneField = 'OneField';
  const ScenarioOneFieldRequired = 'OneFieldRequired';

  public $OriginalPhone;
  public $CountryCode;
  public $CityCode;
  public $Phone;
  public $Type = \contact\models\PhoneType::Mobile;
  public $Id = null;
  public $Delete = 0;

  public function rules()
  {
    return [
      ['CountryCode, CityCode, Phone, Type', 'filter', 'filter' => [new \application\components\utility\Texts(), 'filterPurify']],
      ['CountryCode, Phone', 'required', 'except' => [self::ScenarioOneField, self::ScenarioOneFieldRequired]],
      ['CityCode, Type', 'safe'],
      ['Id, Delete', 'numerical', 'allowEmpty' => true],
      ['CountryCode, CityCode, Phone', 'numerical', 'except' => [self::ScenarioOneField, self::ScenarioOneFieldRequired]],
      ['OriginalPhone', 'safe', 'on' => [self::ScenarioOneField, self::ScenarioOneFieldRequired]],
      ['Phone', 'filter', 'filter' => [$this, 'filterPhone'], 'on' => [self::ScenarioOneField, self::ScenarioOneFieldRequired]]
    ];
  }

  public function filterPhone($value)
  {
    $valid = true;
    if ($this->getScenario() == self::ScenarioOneField)
    {
      if ((!empty($this->OriginalPhone) && $this->getIsEmpty()) || (!empty($this->CountryCode) && empty($this->Phone)) || (empty($this->CountryCode) && !empty($this->Phone)))
        $valid = false;
    }
    elseif ($this->getScenario() == self::ScenarioOneFieldRequired)
    {
      if (empty($this->CountryCode) || empty($this->Phone))
        $valid = false;

    }

    if (!$valid)
    {
      $this->addError('Phone', 'Необходимо заполнить поле Номер телефона.');
    }
    return $value;
  }

  protected function beforeValidate()
  {
    if ($this->getScenario() == self::ScenarioOneField || $this->getScenario() == self::ScenarioOneFieldRequired)
    {
      $attributes = $this->getAttributes();
      if (preg_match('/\+(\d+)(\(\d+\))?([\d-]+)/', $attributes['OriginalPhone'], $matches) > 0)
      {
        $attributes['CountryCode'] = $matches[1];
        if (!empty($matches[2]))
        {
          $attributes['CityCode'] = trim($matches[2], '()');
        }
        $attributes['Phone'] = str_replace('-', '', $matches[3]);
      }
      $this->setAttributes($attributes);
    }
    return parent::beforeValidate();
  }

  public function attributeLabels()
  {
    return array(
      'CountryCode' => \Yii::t('app', 'Код страны'),
      'CityCode' => \Yii::t('app', 'Код города'),
      'Phone' => \Yii::t('app', 'Телефон'),
      'Type' => \Yii::t('app', 'Тип телефона')
    );
  }

  /**
   * @return bool
   */
  public function getIsEmpty()
  {
    return empty($this->CountryCode) && empty($this->Phone);
  }
}
