<?php
namespace event\widgets\header;

class Banner extends \event\widgets\Header
{
  public function getAttributeNames()
  {
    return ['HeaderBannerImagePath', 'HeaderBannerBackgroundColor', 'HeaderBannerHeight'];
  }
  
  public function run()
  {
    $this->render('banner');
  }
  
  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Кастомизированная шапка мероприятия в виде баннера');
  }
  
  /**
   * 
   * @param bool $absolute
   */  
  public function getImageDir($absolute = true)
  {
    return ($absolute ? \Yii::getPathOfAlias('webroot') : '').'/img/event/'.$this->getEvent()->IdName;
  }
}
