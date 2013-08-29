<?php
namespace pay\models\forms;

class Juridical extends \CFormModel
{
  public $Name;
  public $Address;
  public $INN;
  public $KPP;
  public $Phone;
  public $PostAddress;

  public function rules()
  {
    return [
      ['Name, Address, INN, KPP, Phone, PostAddress', 'filter', 'filter' => [new \application\components\utility\Texts(), 'filterPurify']],
      ['Name, Address, INN, KPP, Phone', 'required'],
      ['PostAddress', 'safe']
    ];
  }

  public function setAttributes($values, $safeOnly = true)
  {
    if (!isset($values['PostAddress']) || mb_strlen($values['PostAddress']) == 0)
    {
      $values['PostAddress'] = isset($values['Address']) ? $values['Address'] : '';
    }
    parent::setAttributes($values, $safeOnly);
  }


  public function attributeLabels()
  {
    return array(
      'Name' => \Yii::t('app', 'Название компании'),
      'Address' => \Yii::t('app', 'Юридический адрес (с индексом)'),
      'INN' => \Yii::t('app', 'ИНН'),
      'KPP' => \Yii::t('app', 'КПП'),
      'Phone' => \Yii::t('app', 'Телефон'),
      'PostAddress' => \Yii::t('app', 'Почтовый адрес (с индексом)'),
    );
  }
}
