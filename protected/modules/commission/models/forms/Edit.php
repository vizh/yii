<?php
namespace commission\models\forms;

class Edit extends \CFormModel
{
  public $Title;
  public $Description;
  public $Url;
  
  public function rules()
  {
    return array(
      array('Title, Description, Url', 'required'),
      array('Url', 'url')
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Title' => \Yii::t('app', 'Название'),
      'Description' => \Yii::t('app', 'Описание'),
      'Url' => \Yii::t('app', 'Ссылка на страницу комиссии')
    );
  }
}
