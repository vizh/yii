<?php
namespace user\models\forms\edit;
class Photo extends \CFormModel
{
  public $Image;
  
  public function rules()
  {
    return array(
      array('Image', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => false),  
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Image' => \Yii::t('app', 'Фотография профиля')
    );
  }
}
