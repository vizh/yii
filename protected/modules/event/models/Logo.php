<?php
namespace event\models;

/**
 * Class Logo
 *
 * @package event\models
 * @property \event\models\Event $event
 */
class Logo
{
    private $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    private function getEventPath($fileName = '', $absolute = false)
    {
        return $this->event->getPath($fileName, $absolute);
    }

    private function getEventDir($absolute = false)
    {
        return $this->event->getDir($absolute);
    }

    /**
     *
     * @param  bool $serverPath
     * @param  string $name
     * @param  string $noFile
     * @return string
     */
    protected function getByName($serverPath, $name, $noFile)
    {
        if ($serverPath || file_exists($this->getEventPath($name, true))) {
            return $this->getEventPath($name, $serverPath);
        }

        return $this->getEventPath("../$noFile");
    }

    protected function getNone($size)
    {
        return 'none/type_'.$this->event->TypeId.'/'.$size.'.png';
    }

    public function save($imagePath)
    {
        $path = $this->getEventDir(true);
        if (!is_dir($path)) {
            mkdir($path);
        }

        $image = \Yii::app()->image->load($imagePath);
        $pathOriginal = $this->getOriginal(true);
        $image->save($pathOriginal);
        $path50 = $this->get50px(true);
        $image->resize(50, 0);
        $image->save($path50);
        $path120 = $this->get120px(true);
        $image->resize(120, 0);
        $image->save($path120);
        $path150 = $this->get150px(true);
        $image->resize(150, 0);
        $image->save($path150);
        $path70 = $this->get70px(true);
        $image->resize(70, 0);
        $image->save($path70);
    }

    public function getOriginal($serverPath = false)
    {
        return $this->getByName($serverPath, 'original.png', 'none.png');
    }

    public function get120px($serverPath = false)
    {
        return $this->getByName($serverPath, '120.png', 'none_120.png');
    }

    public function get150px($serverPath = false)
    {
        return $this->getByName($serverPath, '150.png', 'none_150.png');
    }

    public function get50px($serverPath = false)
    {
        return $this->getByName($serverPath, '50.png', 'none_50.png');
    }

    public function get70px($serverPath = false)
    {
        return $this->getByName($serverPath, '70.png', 'none_70.png');
    }

    /**
     * DEPLICATED
     *
     * @param bool $serverPath
     * @return string
     */
    public function getMini($serverPath = false)
    {
        return $this->get50px($serverPath);
    }

    /**
     * DEPLICATED
     *
     * @param bool $serverPath
     * @return string
     */
    public function getNormal($serverPath = false)
    {
        return $this->get120px($serverPath);
    }

    /**
     * DEPLICATED
     *
     * @param bool|string $serverPath
     * @return string
     */
    public function getSquare70($serverPath = false)
    {
        return $this->get70px($serverPath);
    }
}
