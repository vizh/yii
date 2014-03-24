<?php
namespace pay\models\forms;

class AdditionalAttribute extends \CFormModel
{
  public $Name;
  public $Label;
  public $Type;
  public $Order;

  public function rules()
  {
    return [
      ['Name', 'match', 'pattern' => '/^[a-zA-z]+$/'],
      ['Order', 'numerical'],
      ['Name,Label,Type,Order', 'required']
    ];
  }

  public function attributeLabels()
  {
    return [
      'Name' => \Yii::t('app','Символьный код'),
      'Label' => \Yii::t('app', 'Название'),
      'Type' => \Yii::t('app', 'Тип')
    ];
  }


} 