<?php
namespace news\models;

class Photo
{
    private $news;

    public function __construct($news)
    {
        $this->news = $news;
    }

    /**
     * @param bool $serverPath
     * @return string
     */
    protected function getPath($serverPath = false)
    {
        $path = \Yii::app()->params['NewsPhotoDir'].$this->news->Id.'/';
        if ($serverPath) {
            $path = \Yii::getPathOfAlias('webroot').$path;
        }

        return $path;
    }

    protected function getByName($serverPath, $name, $noFile)
    {
        if ($serverPath || file_exists($this->getPath(true).$name)) {
            return $this->getPath($serverPath).$name;
        } else {
            return $this->getPath($serverPath).$noFile;
        }
    }

    /**
     * Возвращает путь к изображению новости шириной 140px
     *
     * @param bool $serverPath
     * @return string
     */
    public function get140px($serverPath = false)
    {
        return $this->getByName($serverPath, '140.png', 'nophoto_140.png');
    }

    /**
     * Возвращает путь к исходному изображению новости
     *
     * @param bool $serverPath
     * @return string
     */
    public function getOriginal($serverPath = false)
    {
        return $this->getByName($serverPath, 'original.png', 'nophoto_200.png');
    }

    /**
     *
     * @param $image
     * @return void
     */
    public function savePhoto($image)
    {
        $path = $this->getPath(true);
        if (!is_dir($path)) {
            mkdir($path);
        }

        $image = \Yii::app()->image->load($image);
        $pathOriginal = $this->getOriginal(true);
        $image->save($pathOriginal);

        $path140 = $this->get140px(true);
        $image->resize(140, 0);
        $image->save($path140);
    }
}