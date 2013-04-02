<?php
namespace user\models\forms\edit;

class Contacts extends \CFormModel
{
  public $Email;
  public $Site;
  public $Phones = array();
  public $Accounts = array();
  
  
  public function getPhoneTypeOptions()
  {
    $types = array(
     \contact\models\PhoneType::Mobile => \Yii::t('app', 'Мобильный'),
     \contact\models\PhoneType::Work => \Yii::t('app', 'Рабочий')
    );
    $result = '';
    foreach ($types as $type => $title)
    {
      $result .= '<option value="'. $type.'">'.$title.'</option>';
    }
    return $result;
  }
}
