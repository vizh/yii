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
    \Yii::app()->getClientScript()->registerPackage('runetid.jquery.colorwheel');
    return $this->renderView(['form' => $this->form]);
  }

  public function process()
  {
    $request = \Yii::app()->getRequest();
    $this->form->attributes = $request->getParam(get_class($this->form));
    $this->form->Image = \CUploadedFile::getInstance($this->form, 'Image');
    if ($this->form->validate())
    {
      $this->getWidget()->HeaderBannerBackgroundColor = $this->form->BackgroundColor;
      $this->getWidget()->HeaderBannerHeight = $this->form->Height;
      if ($this->form->Image !== null)
      {
        $path  = '/img/event/'.$this->getEvent()->IdName.'/header-bg.'.$this->form->Image->getExtensionName();
        $this->form->Image->saveAs(\Yii::getPathOfAlias('webroot').$path);
        $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot').$path);
        $image->quality(100);
        $image->resize(940,300);
        $image->save();
        $this->getWidget()->HeaderBannerImagePath = $path;
        $this->getWidget()->HeaderBannerHeight = $image->height;
      }
      $this->setSuccess(\Yii::t('app', 'Настройки виджета успешно сохранены'));
      return true;
    }
    $this->addError($this->form->getErrors());
    return false;
  } 
}
