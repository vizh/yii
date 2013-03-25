<?php
namespace user\models\forms\edit;
class Main extends \user\models\forms\edit\Base
{
  public $LastName;
  public $FirstName;
  public $FatherName;
  public $Birthday;
  public $Gender = \user\models\Gender::None;
  
  public function rules()
  {
    return array(
      array('LastName, FirstName, FatherName, Birthday, Gender', 'filter', 'filter' => array($this, 'filterPurify')),
      array('LastName, FirstName', 'required'),
      array('FatherName, Gender', 'safe'),
      array('Birthday', 'date', 'format' => 'dd.MM.yyyy'),
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'LastName' => \Yii::t('app', 'Фамилия').' <span class="required">*</span>',
      'FatherName' => \Yii::t('app', 'Отчество'),
      'FirstName' => \Yii::t('app', 'Имя'). ' <span class="required">*</span>',
      'Birthday' => \Yii::t('app', 'Дата рождения')
    );
  }
  
  public function getGenderList()
  {
    return array(
      \user\models\Gender::Male   => \Yii::t('app', 'Мужчина'),
      \user\models\Gender::Female => \Yii::t('app', 'Женщина'),
      \user\models\Gender::None   => \Yii::t('app', 'Не указывать'),  
    );
  }
  
  
}
