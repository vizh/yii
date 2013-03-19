<?php
namespace pay\models\forms;

class Juridical extends \CFormModel
{
  public $Name;
  public $Address;
  public $INN;
  public $KPP;
  public $Phone;
  public $Fax;
  public $PostAddress;

  public function rules()
  {
    return array(
      array('Name, Address, INN, KPP, Phone, Fax', 'required'),
      array('PostAddress', 'safe')
    );
  }

  public function setAttributes($values, $safeOnly = true)
  {
    if (!isset($values['PostAddress']) || mb_strlen($values['PostAddress']) == 0)
    {
      $values['PostAddress'] = isset($values['Address']) ? $values['Address'] : '';
    }
    return parent::setAttributes($values, $safeOnly);
  }


  public function attributeLabels()
  {
    return array(
      'Name' => \Yii::t('pay', 'Название компании'),
      'Address' => \Yii::t('pay', 'Юридический адрес (с индексом)'),
      'INN' => \Yii::t('pay', 'ИНН'),
      'KPP' => \Yii::t('pay', 'КПП'),
      'Phone' => \Yii::t('pay', 'Телефон'),
      'Fax' => \Yii::t('pay', 'Факс'),
      'PostAddress' => \Yii::t('pay', 'Почтовый адрес (с индексом)'),
    );
  }
}
