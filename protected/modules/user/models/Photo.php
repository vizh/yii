<?php
namespace user\models;

use application\components\Exception;
use GuzzleHttp;

class Photo
{
    private $runetId;
    private static $guzzle;

    /**
     * Constructor
     *
     * @param int $runetId
     */
    public function __construct($runetId)
    {
        $this->runetId = $runetId;
    }

    /**
     * Возвращает путь к мини изображению пользователя, для навигационного бара
     *
     * @param bool $serverPath
     *
     * @return string
     */
    public function get18px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId.'_50.jpg', 'nophoto_50.png');
    }

    /**
     * Возвращает путь к мини изображению пользователя, для шапки сайта, отображения в компаниях и тп
     *
     * @param bool $serverPath
     * @return string
     */
    public function get50px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId.'_50.jpg', 'nophoto_50.png');
    }

    /**
     * Возвращает путь к мини изображению пользователя, для страницы мероприятия
     *
     * @param bool $serverPath
     *
     * @return string
     */
    public function get58px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId.'_90.jpg', 'nophoto_58.png');
    }

    /**
     * Возвращает путь к мини изображению пользователя, для шапки сайта, отображения в компаниях и тп
     *
     * @param bool $serverPath
     * @return string
     */
    public function get90px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId.'_90.jpg', 'nophoto_90.png');
    }

    /**
     * Возвращает путь к изображению пользователя для профиля и тп
     *
     * @param bool $serverPath
     * @return string
     */
    public function get200px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId.'_200.jpg', 'nophoto_200.png');
    }

    /**
     * Возвращает путь к изображению пользователя для профиля и тп
     *
     * @param bool $serverPath
     * @return string
     */
    public function get238px($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId.'_200.jpg', 'nophoto_200.png');
    }

    /**
     * Возвращает путь к исходному изображению пользователя
     *
     * @param bool $serverPath
     * @return string
     */
    public function getOriginal($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId.'.jpg', 'nophoto_200.png');
    }

    /**
     * Проверяет наличие изображения
     *
     * @return boolean
     */
    public function hasImage()
    {
        return file_exists($fileName = $this->getPath(true).$this->runetId.'.jpg');
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
     *
     * @param string $path
     * @throws Exception
     */
    public function save($path)
    {
        $dir = $this->getPath(true);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Встроенные средства php не могут обрабатывать самоподписанные SSL сертификаты, минихак для этого случая
        if (filter_var($path, FILTER_VALIDATE_URL) !== false) {
            // Инициализация GuzzleHttp
            if (self::$guzzle === null) {
                self::$guzzle = new GuzzleHttp\Client();
                self::$guzzle->setDefaultOption('verify', false);
            }
            // Генерируем уникальное имя временного файла
            $pathOverride = tempnam(sys_get_temp_dir(), 'user_photo_');
            // Скачиваем файл
            self::$guzzle->get($path, ['sink' => $pathOverride]);
            // Используем временный файл в качестве устанавливаемого изображения
            $path = $pathOverride;
        }

        $image = new \Imagick($path);
        $image->writeImage($this->getOriginal(true));

        $this->saveResizedImage();

        // Если в процессе работы был создал временный файл, то удаляем его
        if (isset($pathOverride) && false === unlink($pathOverride)) {
            throw new Exception('Не удалось удалить временный файл при загрузке фотографии пользователя');
        }
    }

    /**
     * Makes resizes of the photo
     *
     * @param int $x
     * @param int $y
     * @param int $width
     * @param int $height
     */
    public function crop($x, $y, $width, $height)
    {
        $image = new \Imagick($this->getOriginal(true));
        $image->cropImage($width, $height, $x, $y);
        $image->writeImage($this->getOriginal(true));

        $this->saveResizedImage();
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
     *
     * @param bool $serverPath
     * @return string
     */
    protected function getClear($serverPath = false)
    {
        return $this->getByName($serverPath, $this->runetId.'_clear.jpg', 'nophoto_200.png');
    }

    /**
     * @param bool $serverPath
     * @return string
     */
    protected function getPath($serverPath = false)
    {
        $folder = $this->runetId / 10000;
        $folder = (int)$folder;
        $result = \Yii::app()->params['UserPhotoDir'].$folder.'/';

        if ($serverPath) {
            $result = \Yii::getPathOfAlias('webroot').$result;
        }

        return $result;
    }

    /**
     * Returns path to the user photo
     *
     * @param string $serverPath
     * @param string $name
     * @param string $noFile
     * @return string
     */
    protected function getByName($serverPath, $name, $noFile)
    {
        $fileName = $this->getPath(true).$name;
        if ($serverPath || file_exists($fileName)) {
            $mtime = @filemtime($fileName);

            return $this->getPath($serverPath).$name.($serverPath ? '' : '?t='.$mtime);
        } else {
            return \Yii::app()->params['UserPhotoDir'].$noFile;
        }
    }

    /**
     * Saves resized images
     */
    private function saveResizedImage()
    {
        $clearSaveTo = $this->getClear(true);

        $image = new \Imagick($this->getOriginal(true));
        $image->writeImage($clearSaveTo);

        // [width, height]
        $sizes = [
            [238, 238],
            [200, 200],
            [90, 90],
            [50, 50]
        ];

        foreach ($sizes as $size) {
            $image = new \Imagick($this->getOriginal(true));

            $width = $size[0];
            $height = $size[1];

            $method = 'get'.$height.'px';
            $image->resizeImage($width, 0, \Imagick::FILTER_LANCZOS, 1);
            $image->writeImage($this->$method(true));
        }
    }
}
