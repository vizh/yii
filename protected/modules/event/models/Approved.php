<?php
namespace event\models;
final class Approved
{
  const Yes    =  1;
  const No     = -1; 
  const None   =  0;
  
  public static function getLabels()
  {
    return [
      self::None => \Yii::t('app', 'На рассмотрении'),
      self::Yes  => \Yii::t('app', 'Подтвержден'),
      self::No   => \Yii::t('app', 'Отклонен')
    ];
  }
}
