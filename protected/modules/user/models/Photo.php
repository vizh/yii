<?php
namespace user\models;

use application\components\graphics\Image;

class Photo
{
    private $runetId;

    public function __construct($runetId)
    {
        $this->runetId = $runetId;
    }

    /**
     * @param bool $serverPath
     * @return string
     */
    protected function getPath($serverPath = false)
    {
        $folder = $this->runetId / 10000;
        $folder = (int)$folder;
        $result = \Yii::app()->params['UserPhotoDir'] . $folder . '/';
        if ($serverPath) {
            $result = \Yii::getPathOfAlias('webroot') . $result;
        }
        return $result;
    }

    protected function getByName($serverPath, $name, $noFile)
    {
        if ($serverPath || file_exists($this->getPath(true) . $name)) {
            return $this->getPath($serverPath) . $name;
        } else {
            return \Yii::app()->params['UserPhotoDir'] . $noFile;
        }
    }

    /**
     * Возвращает путь к мини изображению пользователя, для навигационного бара
     * @param bool $serverPath
     *
     * @return string
     */
    public function get18px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId . '_50.jpg', 'nophoto_50.png');
    }

    /**
     * Возвращает путь к мини изображению пользователя, для шапки сайта, отображения в компаниях и тп
     * @param bool $serverPath
     * @return string
     */
    public function get50px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId . '_50.jpg', 'nophoto_50.png');
    }

    /**
     * Возвращает путь к мини изображению пользователя, для страницы мероприятия
     * @param bool $serverPath
     *
     * @return string
     */
    public function get58px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId . '_90.jpg', 'nophoto_58.png');
    }

    /**
     * Возвращает путь к мини изображению пользователя, для шапки сайта, отображения в компаниях и тп
     * @param bool $serverPath
     * @return string
     */
    public function get90px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId . '_90.jpg', 'nophoto_90.png');
    }

    /**
     * Возвращает путь к изображению пользователя для профиля и тп
     * @param bool $serverPath
     * @return string
     */
    public function get200px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId . '_200.jpg', 'nophoto_200.png');
    }

    /**
     * Возвращает путь к изображению пользователя для профиля и тп
     * @param bool $serverPath
     * @return string
     */
    public function get238px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId . '_200.jpg', 'nophoto_200.png');
    }

    /**
     * Возвращает путь к исходному изображению пользователя
     * @param bool $serverPath
     * @return string
     */
    public function getOriginal($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId . '.jpg', 'nophoto_200.png');
    }

    /**
     * Возвращает путь к исходному изображению пользователя
     * @param bool $serverPath
     * @return string
     */
    protected function getClear($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId . '_clear.jpg', 'nophoto_200.png');
    }

    /**
     * @param \CUploadedFile $image
     * @return void
     */
    public function SavePhoto($image)
    {
        $this->saveUploaded($image);
    }

    /**
     * @param \CUploadedFile $file
     */
    public function saveUploaded(\CUploadedFile $file)
    {
        $this->save($file->getTempName());
    }

    /**
     * Сохраняет изображение из исходного файла
     * @param string $path
     */
    public function save($path)
    {
        $dir = $this->getPath(true);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $image = Image::GetImage($path);
        $clearSaveTo = $this->getClear(true);
        imagejpeg($image, $clearSaveTo, 100);
        $newImage = $this->getOriginal(true);
        imagejpeg($image, $newImage, 100);
        imagedestroy($image);
        $newImage = $this->get238px(true);
        Image::ResizeAndSave($clearSaveTo, $newImage, 238, 0, ['x1' => 0, 'y1' => 0]);
        $newImage = $this->get200px(true);
        Image::ResizeAndSave($clearSaveTo, $newImage, 200, 0, ['x1' => 0, 'y1' => 0]);
        $newImage = $this->get90px(true);
        Image::ResizeAndSave($clearSaveTo, $newImage, 90, 90, ['x1' => 0, 'y1' => 0]);
        $newImage = $this->get50px(true);
        Image::ResizeAndSave($clearSaveTo, $newImage, 50, 50, ['x1' => 0, 'y1' => 0]);
    }


    public function delete()
    {
        $methodsMap = ['getClear', 'getOriginal', 'get238px', 'get200px', 'get90px', 'get50px'];
        foreach ($methodsMap as $method) {
            $path = $this->$method(true);
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
