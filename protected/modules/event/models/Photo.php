<?php
namespace event\models;

class Photo
{
    private $id;
    private $event;

    public function __construct($id, $event)
    {
        $this->id = $id;
        $this->event = $event;
    }

    private function getBasePath($absolute)
    {
        return $this->event->getPath('photos/'.$this->id, $absolute);
    }

    private function getByName($name, $absolute)
    {
        return $this->getBasePath($absolute).'/'.$name;
    }

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getOriginal($absolute = false)
    {
        return $this->getBasePath($absolute).'/original.jpg';
    }

    public function get240px($absolute = false)
    {
        return $this->getBasePath($absolute).'/240.jpg';
    }

    public function get900px($absolute = false)
    {
        return $this->getBasePath($absolute).'/900.jpg';
    }

    public function get100px($absolute = false)
    {
        return $this->getBasePath($absolute).'/100.jpg';
    }

    public function get40px($absolute = false)
    {
        return $this->getBasePath($absolute).'/40.jpg';
    }

    public function save($imagePath)
    {
        $path = $this->getBasePath(true);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $image = \Yii::app()->image->load($imagePath);
        $image->quality(100);

        $pathOriginal = $this->getOriginal(true);
        $image->save($pathOriginal);

        $path900 = $this->get900px(true);
        $image->resize(900, 0);
        $image->save($path900);

        $path240 = $this->get240px(true);
        $image->resize(240, 0);
        $image->save($path240);

        $path100 = $this->get100px(true);
        $image->resize(100, 0);
        $image->save($path100);

        $path40 = $this->get40px(true);
        $image->resize(40, 0);
        $image->save($path40);
    }

    public function delete()
    {
        $path = $this->getBasePath(true);
        foreach (new \FilesystemIterator($path) as $item) {
            if ($item->isFile()) {
                unlink($item->getPathname());
            }
        }
        rmdir($path);
    }
}
