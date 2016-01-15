<?php
namespace application\components;

use Gregwar\Cache\Cache;
use Gregwar\Image\Image as GregwarImage;
use \CActiveRecord as ActiveRecord;

class Image
{
    const QUALITY = 90;
    const ORIGINAL_PREFIX = '-origin';

    /** @var string */
    private $cacheName;

    /** @var GregwarImage */
    private $image;

    /**
     * @param \CActiveRecord $model
     * @param null|string $defaultImage Путь до изображения по умолчанию
     * @param null|string $folder Поддериктория, в которую требуется сохранять изображения
     */
    function __construct(ActiveRecord $model, $defaultImage = null, $folder = null)
    {
        $cacheDir = 'upload/images/' . strtolower($model->tableName());
        if ($folder !== null) {
            $cacheDir .= '/' . $folder;
        }

        $this->cacheName = md5($model->getPrimaryKey());
        $this->image = GregwarImage::open()->setCacheDir($cacheDir);

        if ($this->getOriginal() !== null) {
            $this->image->fromFile($this->getOriginal());
        } elseif ($defaultImage !== null) {
            $this->image->fromFile($defaultImage);
        }
    }


    /**
     * @param \CUploadedFile $file
     */
    public function upload(\CUploadedFile $file)
    {
        $this->save($file->getTempName());
    }

    /**
     * Сохраняет изображение
     * @param $path
     */
    public function save($path)
    {
        $this->delete();
        $this->image->setPrettyName(
            $this->cacheName . self::ORIGINAL_PREFIX . time(),
            false
        );
        $this->image->fromFile($path)->guess(self::QUALITY);
    }

    /**
     * Удаляет изображение
     * @throws Exception
     */
    public function delete()
    {
        $this->cachedFileWalk(function (\DirectoryIterator $file) {
            unlink($file->getPathname());
        });
    }

    /**
     * @param string $name
     * @param null|array $params
     * @return null|string
     */
    private function operation($name, $params = null)
    {
        if (!$this->exists()) {
            return null;
        }

        /** @var GregwarImage $image */
        $image = call_user_func_array([$this->image, $name], $params);

        if ($this->existsOriginal()) {
            $this->image->setPrettyName(
                $this->cacheName . '-' . $this->image->getHash('guess', self::QUALITY),
                false
            );
        }
        return '/' . $image->guess(self::QUALITY);
    }

    /**
     * @param int $x
     * @param int|null $y
     * @return string|null
     */
    public function resize($x, $y = null)
    {
        return $this->operation('resize', ['x' => $x, 'y' => $y]);
    }


    /**
     * @param int $x
     * @param int $y
     * @return null
     */
    public function crop($x, $y)
    {
        return $this->operation('zoomCrop', ['x' => $x, 'y' => $y]);
    }


    /**
     * Применяет функцию {@link $callable} для всех закэшированных файлов
     * @param \Closure $callable
     */
    private function cachedFileWalk(\Closure $callable)
    {
        /** @var Cache $cache */
        $cache = $this->image->getCacheSystem();
        $path = \Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . dirname($cache->getCacheFile($this->cacheName));
        if (file_exists($path)) {
            foreach (new \DirectoryIterator($path) as $file) {
                if (!$file->isDot() && strpos($file->getBasename(), $this->cacheName) === 0 && $callable($file) === false) {
                    return;
                }
            }
        }
    }

    /** @var bool|null|string */
    private $original = false;


    /**
     * @return null|string
     */
    public function getOriginal()
    {
        if ($this->original === false) {
            $this->original = null;
            $this->cachedFileWalk(function (\DirectoryIterator $file) {
                if (strpos($file->getBasename(), self::ORIGINAL_PREFIX) !== false) {
                    $this->original = $file->getPathname();
                    return false;
                }
            });
        }
        return $this->original;
    }

    /**
     * Сущсетвует ли оригинальное изображение
     * @return bool
     */
    private function existsOriginal()
    {
        return $this->getOriginal() !== null;
    }

    /**
     * Возмращает существует ли изображение
     * @return bool
     */
    public function exists()
    {
        return $this->existsOriginal() || $this->image->getFilePath() !== null;
    }

    function __call($name, $arguments)
    {
        $mathes = [];
        if (preg_match('/get(\d+)px/i', $name, $mathes) !== 0) {
            return $this->resize($mathes[1]);
        } else {
            parent::__call($name, $arguments);
        }
    }
}