<?php
namespace contact\models\forms;

class ServiceAccount extends \CFormModel
{
  public $TypeId;
  public $Account;
  public $Delete = 0;
  public $Id = null;
  
  public function rules()
  {
    return array(
      array('Account', 'filter', 'filter' => array('application\components\utility\Texts', 'filterPurify')),
      array('Account', 'required'),
      array('TypeId', 'exist', 'className' => '\contact\models\ServiceType', 'attributeName' => 'Id'),
      array('Id,Delete', 'numerical', 'allowEmpty' => true)
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'TypeId' => \Yii::t('app', 'Сервис'),
      'Account' => \Yii::t('app', 'Аккаунт')
    );
  }
}
