<?php
namespace contact\models;

/**
 * @property int $Id
 * @property string $Url
 * @property bool $Secure
 */
class Site extends \application\models\translation\ActiveRecord
{
    /**
     * @param string $className
     * @return Site
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ContactSite';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array();
    }

    public function __toString()
    {
        return ($this->Secure == 1 ? 'https://' : 'http://').trim($this->Url,' /');
    }

    public function getCleanUrl()
    {
        $parts = parse_url($this);
        $url = $parts['scheme'].'://'.$parts['host'];
        if (!empty($parts['path'])) {
            $path = $parts['path'];
            if (strpos($path, 'index.php') !== false) {
                $path = str_replace('index.php', '', $path);
            }
            $url .= $path;
        }
        return $url;
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return array('Url');
    }
}
