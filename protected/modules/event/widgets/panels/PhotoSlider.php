<?php
namespace event\widgets\panels;
class PhotoSlider extends \event\components\WidgetAdminPanel
{ 
  private $photos = [];
  
  public function __construct($widget)
  {
    parent::__construct($widget);
    $path = $this->getEvent()->getPath('photos', true);
    if (file_exists($path))
    {
      foreach (new \DirectoryIterator($path) as $item)
      {
        if ($item->isDir() && !$item->isDot())
          $this->photos[] = new \event\models\Photo($item->getBasename(), $this->getEvent());
      } 
    }
  }


  private function getNextPhotoId()
  {
    $id = 1;
    if (!empty($this->photos))
    {
      $photo = $this->photos[sizeof($this->photos)-1];
      $id = $photo->getId() + 1;
    }
    return $id;
  }


  public function __toString()
  {
    $form = new \event\models\forms\Photo();
    return $this->render(['photos' => $this->photos, 'form' => $form]);
  }
  
  public function process()
  {
    $form = new \event\models\forms\Photo();
    $form->Image = \CUploadedFile::getInstance($form, 'Image');
    if ($form->validate())
    {
      $photo = new \event\models\Photo($this->getNextPhotoId(), $this->getEvent());
      $photo->save($form->Image->getTempName());
      return true;
    }
    $this->addError($form);
    return false;
  }
}
