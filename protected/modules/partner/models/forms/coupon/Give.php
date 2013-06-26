<?php
namespace partner\models\forms\coupon;

class Give extends \CFormModel
{
  public $Recipient;
  
  public function attributeLabels()
  {
    return array(
      'Recipient' => \Yii::t('app', 'Кому выдать купон')  
    );
  }
  
  public function rules()
  {
    return array(
      array('Recipient', 'filter', 'filter' => array(new \application\components\utility\Texts(), 'filterPurify')),
      array('Recipient', 'required')
    );
  }
}
