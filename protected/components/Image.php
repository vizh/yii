<?php
namespace application\components;

use \Exception;

class Image
{
    const ORIGINAL_FILE_NAME = 'original';

    private $model;
    private $folder;
    private $saveExtension;
    private $defaultImagePathname;

    /**
     * @param \CActiveRecord $model
     * @param null|string $defaultImagePathname
     * @param null|string $folder
     * @param int $saveExtension
     */
    function __construct(\CActiveRecord $model, $defaultImagePathname = null, $folder = null, $saveExtension = IMG_JPG)
    {
        $this->model = $model;
        $this->defaultImagePathname = $defaultImagePathname;
        $this->folder = $folder;
        $this->saveExtension = $saveExtension;
    }


    private $basePath = null;

    /**
     * @return null
     * @throws \Exception
     */
    protected function getBasePath()
    {
        if ($this->model->getIsNewRecord()) {
            throw new Exception('Модель не сохранена в базе данных');
        }

        if ($this->basePath == null) {
            $alias = 'webroot.upload.images.';

            $class = get_class($this->model);
            $alias.= substr($class, strrpos($class,'\\')+1);
            if (!empty($this->folder)) {
                $alias.='.'.$this->folder;
            }
            $alias.='.'.substr(md5($this->model->getPrimaryKey()),3,3).'.'.$this->model->getPrimaryKey();

            $alias = strtolower($alias);
            $this->basePath = \Yii::getPathOfAlias($alias).DIRECTORY_SEPARATOR;
            if (!file_exists($this->basePath)) {
                mkdir($this->basePath, 0777, true);
            }
        }
        return $this->basePath;
    }

    /**
     * @return string
     */
    private function getExtension()
    {
        switch ($this->saveExtension) {
            case IMG_PNG: $ext = 'png';
                break;
            case IMG_GIF: $ext = 'gif';
                break;
            default: $ext = 'jpg';
        }
        return $ext;
    }

    private $postfixCacheKey = null;

    /**
     * @return string
     */
    protected function getPostfixCacheKey()
    {
        if ($this->postfixCacheKey == null) {
            $this->postfixCacheKey = implode('_', ['image', get_class($this), $this->folder, $this->model->getPrimaryKey()]);
        }
        return $this->postfixCacheKey;
    }

    /**
     *
     */
    protected function deletePostfixValue()
    {
        \Yii::app()->getCache()->delete($this->getPostfixCacheKey());
    }

    /**
     * @return string
     */
    protected function getPostfixValue()
    {
        $postfix = null;
        $cache   = \Yii::app()->getCache();
        if ($cache->get($this->getPostfixCacheKey()) !== false) {
            $postfix = $cache->get($this->getPostfixCacheKey());
        }
        else {
            if (file_exists($this->getBasePath())) {
                /** @var \DirectoryIterator $item */
                foreach (new \DirectoryIterator($this->getBasePath()) as $item) {
                    if ($item->isFile() && strpos($item->getBasename(), self::ORIGINAL_FILE_NAME) !== null) {
                        $mathes = [];
                        if (preg_match('/'.self::ORIGINAL_FILE_NAME.'_([a-z0-9]+)\./i', $item->getBasename(), $matches)) {
                            if (isset($matches[1])) {
                                $postfix = $matches[1];
                                $cache->set($this->getPostfixCacheKey(), $postfix);
                            }
                            break;
                        }
                    }
                }
            }
        }

        if ($postfix == null) {
            $postfix = substr(md5(time()), 5, 5);
            $cache->set($this->getPostfixCacheKey(), $postfix);
        }
        return $postfix;
    }

    /**
     * @param bool $default
     * @return string|null
     */
    protected function getOriginalPathname($default = true)
    {
        $pathname = $this->getBasePath() . self::ORIGINAL_FILE_NAME . '_' . $this->getPostfixValue() . '.' . $this->getExtension();
        if (!file_exists($pathname) && $default) {
            if (file_exists($this->defaultImagePathname)) {
                $pathname = $this->defaultImagePathname;
            } else {
                return null;
            }
        }
        return $pathname;
    }

    /**
     * @param string $action
     * @param string[] $params
     * @return string
     */
    protected function getPathname($action, $params = [])
    {
        $name = $action . (!empty($params) ? '-'.implode('x', $params) : '');

        $originalPathname = $this->getOriginalPathname();
        if ($originalPathname !== null) {
            if (strpos($originalPathname, self::ORIGINAL_FILE_NAME) !== false) {
                return $this->getBasePath() . $name . '_' . $this->getPostfixValue() . '.' . $this->getExtension();
            } else {
                return substr($originalPathname, 0, strrpos($originalPathname,'.')) . '-' . $name . '.' . $this->getExtension();
            }
        }
    }

    /**
     * @param string $pathname
     * @return string
     */
    protected function getUrl($pathname) {
        return str_replace([\Yii::getPathOfAlias('webroot'),'\\'], ['','/'], $pathname);
    }

    /**
     * @param \CUploadedFile $file
     */
    public function saveUpload(\CUploadedFile $file)
    {
        $this->save($file->tempName);
    }

    /**
     * @param string $file
     */
    public function save($path = null)
    {
        $this->delete();
        $image = \Yii::app()->image->load($path);
        $this->deletePostfixValue();
        $image->save($this->getOriginalPathname(false));
    }

    public function delete()
    {
        /** @var \DirectoryIterator $item */
        foreach(new \DirectoryIterator($this->getBasePath()) as $item) {
            if ($item->isFile()) {
                unlink($item->getPathname());
            }
        }
    }

    /**
     * @param int $x
     * @param int $y
     * @return string
     */
    public function resize($x, $y = 0)
    {
        $pathname = $this->getPathname('resize', [$x,$y]);
        if (!file_exists($pathname)) {
            $originalPathname = $this->getOriginalPathname();
            if ($originalPathname !== null) {
                $image = \Yii::app()->image->load($this->getOriginalPathname());
                if ($image->width <= $x) {
                    $x = $image->width;
                }
                if ($y != 0 && $image->height <= $y) {
                    $y = $image->height;
                }
                $image->resize($x,$y);
                $image->save($pathname);
            } else {
                return null;
            }
        }
        return $this->getUrl($pathname);
    }

    public function crop($x, $y)
    {
        $pathname = $this->getPathname('resize', [$x,$y]);
        if (!file_exists($pathname)) {
            $originalPathname = $this->getOriginalPathname();
            if ($originalPathname !== null) {
                $image = \Yii::app()->image->load($this->getOriginalPathname());
                $height = round($image->height / $image->width * $x);
                if ($height >= $y)
                {
                    $image->resize($x,0);
                }
                else
                {
                    $image->resize(0,$y);
                }
                $image->crop($x, $y);
                $image->save($pathname);
            } else {
                return null;
            }
        }
        return $this->getUrl($pathname);
    }

    /**
     * @return null|string
     */
    public function getOriginal()
    {
        $pathname = $this->getOriginalPathname();
        if ($pathname !== null) {
            return $this->getUrl($pathname);
        }
        return null;
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

    /**
     * Возмращает существует ли изображение
     * @return bool
     */
    public function exists()
    {
        if (!$this->model->getIsNewRecord() && $this->getOriginal() !== null) {
            return true;
        }
        return false;
    }
} 