<?php
namespace user\models;

use application\components\graphics\Image;

class Photo
{
    private $runetId;

    /**
     * Constructor
     * @param int $runetId
     */
    public function __construct($runetId)
    {
        $this->runetId = $runetId;
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
     * Проверяет наличие изображения
     * @return boolean
     */
    public function hasImage()
    {
        return file_exists($fileName = $this->getPath(true) . $this->runetId . '.jpg');
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

        imagejpeg($image, $this->getOriginal(true), 100);
        $this->saveResizedImage($image);

        imagedestroy($image);
    }

    /**
     * Makes resizes of the photo
     *
     * @param int $x
     * @param int $y
     * @param int $width
     * @param int $height
     */
    public function resize($x, $y, $width, $height)
    {
        $cropFileName = $this->getPath(true) . $this->runetId . '_crop.jpg';

        Image::ResizeAndSave(
            $this->getOriginal(true),
            $cropFileName,
            intval($width),
            intval($height),
            ['x1' => intval($x), 'y1' => intval($y)]
        );

        $image = Image::GetImage($cropFileName);

        imagejpeg($image, $this->getOriginal(true), 100);
        $this->saveResizedImage($image);
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

    /**
     * Returns path to the user photo
     * @param string $serverPath
     * @param string $name
     * @param string $noFile
     * @return string
     */
    protected function getByName($serverPath, $name, $noFile)
    {
        $fileName = $this->getPath(true) . $name;
        if ($serverPath || file_exists($fileName)) {
            $mtime = @filemtime($fileName);
            return $this->getPath($serverPath) . $name . ($serverPath ? '' : '?t=' . $mtime);
        } else {
            return \Yii::app()->params['UserPhotoDir'] . $noFile;
        }
    }

    /**
     * Saves resized images
     *
     * @param \Image $image
     */
    private function saveResizedImage($image)
    {
        $clearSaveTo = $this->getClear(true);

        imagejpeg($image, $clearSaveTo, 100);

        Image::ResizeAndSave($clearSaveTo, $this->get238px(true), 238, 0, ['x1' => 0, 'y1' => 0]);
        Image::ResizeAndSave($clearSaveTo, $this->get200px(true), 200, 0, ['x1' => 0, 'y1' => 0]);
        Image::ResizeAndSave($clearSaveTo, $this->get90px(true), 90, 90, ['x1' => 0, 'y1' => 0]);
        Image::ResizeAndSave($clearSaveTo, $this->get50px(true), 50, 50, ['x1' => 0, 'y1' => 0]);
    }
}
