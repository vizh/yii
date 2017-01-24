<?php
namespace catalog\models\company;

class Logo
{
    const VECTOR_NAME = 'vector';
    const ORIGINAL_NAME = 'original';
    const W100PX_NAME = '100';

    protected $id;
    protected $company;
    protected $path;

    private $filesName = [
        self::VECTOR_NAME => null,
        self::ORIGINAL_NAME => null,
        self::W100PX_NAME => null
    ];

    public function __construct($id, $company)
    {
        $this->id = $id;
        $this->company = $company;
        $this->path = $this->company->getPath($id, true);

        if (file_exists($this->path)) {
            $dirContent = scandir($this->path);
            foreach ($dirContent as $content) {
                $name = substr($content, 0, strrpos($content, '.'));
                if (key_exists($name, $this->filesName)) {
                    $this->filesName[$name] = $this->getId().'/'.$content;
                }
            }
        }
    }

    /**
     *
     * @param  string $name
     * @return string
     */
    public function getAbsolutePath($name)
    {
        return $this->path.DIRECTORY_SEPARATOR.$name;
    }

    /**
     *
     * @return type
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $name
     * @param bool $absolute
     * @return string|null
     */
    protected function getPathByName($name, $absolute = false)
    {
        if (empty($this->filesName[$name])) {
            return null;
        }

        return $this->company->getPath($this->filesName[$name], $absolute);
    }

    /**
     *
     * @param bool $absolute
     * @return string|null
     */
    public function getVector($absolute = false)
    {
        return $this->getPathByName(self::VECTOR_NAME, $absolute);
    }

    /**
     *
     * @param bool $absolute
     * @return string|null
     */
    public function getOriginal($absolute = false)
    {
        return $this->getPathByName(self::ORIGINAL_NAME, $absolute);
    }

    /**
     *
     * @param bool $absolute
     * @return string|null
     */
    public function get100px($absolute = false)
    {
        return $this->getPathByName(self::W100PX_NAME, $absolute);
    }

    /**
     *
     * @param \catalog\models\company\forms\Logo $form
     */
    public function save(\catalog\models\company\forms\Logo $form)
    {
        if (!file_exists($this->path)) {
            mkdir($this->path);
        }

        if (!empty($form->Raster)) {
            if (!empty($this->filesName[self::ORIGINAL_NAME])) {
                unlink($this->getPathByName(self::ORIGINAL_NAME, true));
            }

            $image = \Yii::app()->image->load($form->Raster->getTempName());
            $image->save(
                $this->getAbsolutePath(self::ORIGINAL_NAME.'.'.\CFileHelper::getExtension($form->Raster->getName()))
            );

            if (empty($form->W100px)) {
                $image->resize(100, 0);
                $image->save($this->getAbsolutePath(self::W100PX_NAME.'.png'));
            }
        }

        if (!empty($form->Vector)) {
            if (!empty($this->filesName[self::VECTOR_NAME])) {
                unlink($this->getPathByName(self::VECTOR_NAME, true));
            }

            $form->Vector->saveAs(
                $this->getAbsolutePath(self::VECTOR_NAME.'.'.\CFileHelper::getExtension($form->Vector->getName()))
            );
        }

        if (!empty($form->W100px)) {
            if (!empty($this->filesName[self::W100PX_NAME])) {
                unlink($this->getPathByName(self::W100PX_NAME, true));
            }

            $form->W100px->saveAs(
                $this->getAbsolutePath(self::W100PX_NAME.'.'.\CFileHelper::getExtension($form->W100px->getName()))
            );
        }
    }

    /**
     *
     */
    public function delete()
    {
        $dirContent = scandir($this->path);
        foreach ($dirContent as $content) {
            $path = $this->getAbsolutePath($content);
            if (is_file($path)) {
                unlink($path);
            }
        }
        rmdir($this->path);
    }
}
