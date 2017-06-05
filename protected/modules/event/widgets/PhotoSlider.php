<?php
namespace event\widgets;

/**
 * @property string[]|string $PhotoSliderImages
 */
class PhotoSlider extends \event\components\Widget
{
    public function init()
    {
        \Yii::app()->clientScript->registerPackage('runetid.jquery.ioslider');
        parent::init();
    }

    public function run()
    {
        $this->render('photoslider', []);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Слайдер фотографий');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Sidebar;
    }

    public function getPhotosPath()
    {
        return $this->getEvent()->getPath('photos', true);
    }

    private $photos = null;

    public function getPhotos()
    {
        if ($this->photos == null) {
            $path = $this->getPhotosPath();
            if (file_exists($path)) {
                $this->photos = [];
                foreach (new \DirectoryIterator($path) as $item) {
                    if ($item->isDir() && !$item->isDot()) {
                        $this->photos[$item->getBasename()] = new \event\models\Photo($item->getBasename(), $this->getEvent());
                    }
                }
                ksort($this->photos);
            }
        }
        return $this->photos;
    }

    public function getIsActive()
    {
        if (file_exists($this->getPhotosPath())) {
            return sizeof(scandir($this->getPhotosPath())) > 2;
        }
        return false;
    }
}
