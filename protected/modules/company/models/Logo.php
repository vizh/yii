<?php
namespace company\models;

class Logo
{
    private $company;

    public function __construct($company)
    {
        $this->company = $company;
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
        if ($serverPath || file_exists($this->getPath(true).$name)) {
            return $this->getPath($serverPath).$name;
        } else {
            return \Yii::app()->params['CompanyDir'].$noFile;
        }
    }

    /**
     * @param bool $serverPath
     * @return string
     */
    protected function getPath($serverPath = false)
    {
        $result = \Yii::app()->params['CompanyDir'].$this->company->Id.'/';
        if ($serverPath) {
            $result = \Yii::getPathOfAlias('webroot').$result;
        }

        return $result;
    }

    public function save($imagePath)
    {
        $path = $this->getPath(true);
        if (!is_dir($path)) {
            mkdir($path);
        }

        $image = \Yii::app()->image->load($imagePath);
        $pathOriginal = $this->getOriginal(true);
        $image->save($pathOriginal);

        $path200 = $this->get200px(true);
        $image->resize(200, 0);
        $image->save($path200);

        $path150 = $this->get150px(true);
        $image->resize(150, 0);
        $image->save($path150);

        $path58 = $this->get58px(true);
        $image->resize(58, 0);
        $image->save($path58);
    }

    public function getOriginal($serverPath = false)
    {
        return $this->getByName($serverPath, 'original.png', 'none.png');
    }

    public function get200px($serverPath = false)
    {
        return $this->getByName($serverPath, '200.png', 'none_200.png');
    }

    public function get150px($serverPath = false)
    {
        return $this->getByName($serverPath, '150.png', 'none_150.png');
    }

    public function get58px($serverPath = false)
    {
        return $this->getByName($serverPath, '58.png', 'none_58.png');
    }
}
