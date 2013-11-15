<?php
namespace event\models\forms\widgets\header;

class Banner extends \CFormModel
{
  public $Image;
  public $BackgroundColor;
  public $BackgroundImage;
  public $Styles;
  public $Height;
  
  public function rules()
  {
    return [
      ['BackgroundColor', 'required'],
      ['Image, BackgroundImage', 'file', 'types' => 'jpg,jpeg,png', 'allowEmpty' => true],
      ['Height', 'numerical', 'max' => \Yii::app()->params['EventWidgetBannerMaxHeight'], 'min' => 100, 'allowEmpty' => true],
      ['Styles', 'safe']
    ];
  }
  
  public function attributeLabels()
  {
    return [
      'BackgroundColor' => \Yii::t('app', 'Цвет фона'),
      'BackgroundImage' => \Yii::t('app', 'Фоновое изображение'),
      'Image' => \Yii::t('app', 'Основное изображение'),
      'Height' => \Yii::t('app', 'Высота (в пикселях)'),
      'Styles' => \Yii::t('app', 'Стили')
    ];
  }
}
