<?php
namespace event\widgets\panels\header;
class Banner extends \event\components\WidgetAdminPanel
{
  private $form;
  public function __construct($widget)
  {
    parent::__construct($widget);
    $this->form = new \event\models\forms\widgets\header\Banner();
  }
  
  public function render()
  {
    $this->form->BackgroundColor = isset($this->getWidget()->HeaderBannerBackgroundColor) ? $this->getWidget()->HeaderBannerBackgroundColor : '';
    $this->form->Height = isset($this->getWidget()->HeaderBannerHeight) ? $this->getWidget()->HeaderBannerHeight : '';
    $this->form->Styles = isset($this->getWidget()->HeaderBannerStyles) ? $this->getWidget()->HeaderBannerStyles : '';
    \Yii::app()->getClientScript()->registerPackage('runetid.jquery.colorwheel');
    return $this->renderView(['form' => $this->form]);
  }

  public function process()
  {
    $request = \Yii::app()->getRequest();
    $this->form->attributes = $request->getParam(get_class($this->form));
    $this->form->Image = \CUploadedFile::getInstance($this->form, 'Image');
    $this->form->BackgroundImage = \CUploadedFile::getInstance($this->form, 'BackgroundImage');
    if ($this->form->validate())
    {
      $this->getWidget()->HeaderBannerBackgroundColor = $this->form->BackgroundColor;
      $this->getWidget()->HeaderBannerHeight = $this->form->Height;
      $this->getWidget()->HeaderBannerStyles = $this->form->Styles;
      if ($this->form->Image !== null)
      {
        $path = $this->getWidget()->getImageDir();
        $name = '/header-bg.'.$this->form->Image->getExtensionName();
        if (!file_exists($path))
        {
          mkdir($path);
        }
        $this->form->Image->saveAs($path.$name);
        $image = \Yii::app()->image->load($path.$name);
        $image->quality(100);
        if ($image->width > 940 || $image->height > \Yii::app()->params['EventWidgetBannerMaxHeight'])
        {
          $image->resize(940, \Yii::app()->params['EventWidgetBannerMaxHeight']);
        }
        $image->save();
        $this->getWidget()->HeaderBannerImagePath = $this->getWidget()->getImageDir(false).$name;
        $image = \Yii::app()->image->load($path.$name);
        $this->getWidget()->HeaderBannerHeight = $image->height;
      }
      
      if ($this->form->BackgroundImage !== null)
      {
        $path = $this->getWidget()->getImageDir();
        $name = '/header-bg-fill.'.$this->form->BackgroundImage->getExtensionName();
        if (!file_exists($path))
        {
          mkdir($path);
        }
        $this->form->BackgroundImage->saveAs($path.$name);
        $image = \Yii::app()->image->load($path.$name);
        $image->quality(100);
        if ($image->height > \Yii::app()->params['EventWidgetBannerMaxHeight'])
        {
          $image->resize(0,\Yii::app()->params['EventWidgetBannerMaxHeight']);
        }
        $image->save();
        $this->getWidget()->HeaderBannerBackgroundImagePath = $this->getWidget()->getImageDir(false).$name;
      }
      
      $this->setSuccess(\Yii::t('app', 'Настройки виджета успешно сохранены'));
      return true;
    }
    $this->addError($this->form->getErrors());
    return false;
  } 
}
