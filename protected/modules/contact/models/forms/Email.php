<?php
namespace contact\models\forms;

class Email extends \CFormModel
{
  public $Email;
  public $Title;
  public $Id = null;
  public $Delete = 0;


  public function rules()
  {
    return array(
      array('Title', 'filter', 'filter' => array('application\components\utility\Texts', 'filterPurify')),
      array('Email', 'required'),
      array('Email', 'email'),
      array('Id, Delete', 'numerical', 'allowEmpty' => true)
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Email' => \Yii::t('app', 'Адрес эл. почты'),
      'Title' => \Yii::t('app', 'Описание'),
    );
  }
}
