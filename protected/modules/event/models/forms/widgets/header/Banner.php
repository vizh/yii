<?php
namespace event\models\forms\widgets\header;

class Banner extends \CFormModel
{
  public $Image;
  public $BackgroundColor;
  public $Height;
  
  public function rules()
  {
    return [
      ['BackgroundColor', 'required'],
      ['Image', 'file', 'types' => 'jpg,jpeg,png', 'allowEmpty' => true],
      ['Height', 'numerical', 'max' => 300, 'min' => 100, 'allowEmpty' => true]
    ];
  }
  
  public function attributeLabels()
  {
    return [
      'BackgroundColor' => \Yii::t('app', 'Цвет фона'),
      'Image' => \Yii::t('app', 'Фоновое изображение'),
      'Height' => \Yii::t('app', 'Высота (в пикселях)')
    ];
  }
}
