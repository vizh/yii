<?php
namespace event\widgets\panels;

class PhotoSlider extends \event\components\WidgetAdminPanel
{
    private function getNextPhotoId()
    {
        $id = 1;
        $photos = $this->widget->getPhotos();
        if (!empty($photos)) {
            $photo = $photos[sizeof($photos)];
            $id = $photo->getId() + 1;
        }
        return $id;
    }

    public function render()
    {
        $form = new \event\models\forms\Photo();
        return $this->renderView(['photos' => $this->widget->getPhotos(), 'form' => $form]);
    }

    public function process()
    {
        $request = \Yii::app()->getRequest();
        if ($request->getIsAjaxRequest() && ($action = $request->getParam('Action')) !== null) {
            if ($action == 'AjaxDelete') {
                $this->processPhotoDelete();
            } else if ($action == 'AjaxSort') {
                $this->processPhotoSort();
            }
            \Yii::app()->end();
        }

        $form = new \event\models\forms\Photo();
        $form->Image = \CUploadedFile::getInstance($form, 'Image');
        if ($form->validate()) {
            $photo = new \event\models\Photo($this->getNextPhotoId(), $this->getEvent());
            $photo->save($form->Image->getTempName());
            $this->setSuccess(\Yii::t('app', 'Фотография успешно добавлена'));
            return true;
        }
        $this->addError($form->getErrors());
        return false;
    }

    private function processPhotoDelete()
    {
        $photoId = \Yii::app()->getRequest()->getParam('PhotoId');
        foreach ($this->widget->getPhotos() as $photo) {
            if ($photo->getId() == $photoId) {
                $photo->delete();
            }
        }
    }

    private function processPhotoSort()
    {
        $positions = \Yii::app()->getRequest()->getParam('Positions');
        $basePath = $this->widget->getPhotosPath();
        foreach ($positions as $photoId => $position) {
            rename($basePath.DIRECTORY_SEPARATOR.$photoId, $basePath.DIRECTORY_SEPARATOR.'_'.$position);
        }

        $dirContent = scandir($basePath);
        foreach ($dirContent as $item) {
            if (is_dir($basePath.DIRECTORY_SEPARATOR.$item) && !strstr($item, '.')) {
                rename($basePath.DIRECTORY_SEPARATOR.$item, $basePath.DIRECTORY_SEPARATOR.str_replace('_', '', $item));
            }
        }
    }
}
