<?php
namespace contact\models;

use application\models\translation\ActiveRecord;

/**
 * @property int $Id
 * @property string $Url
 * @property bool $Secure
 *
 * Описание вспомогательных методов
 * @method Site   with($condition = '')
 * @method Site   find($condition = '', $params = [])
 * @method Site   findByPk($pk, $condition = '', $params = [])
 * @method Site   findByAttributes($attributes, $condition = '', $params = [])
 * @method Site[] findAll($condition = '', $params = [])
 * @method Site[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Site byId(int $id, bool $useAnd = true)
 * @method Site byUrl(string $url, bool $useAnd = true)
 * @method Site bySecure(bool $secure, bool $useAnd = true)
 */
class Site extends ActiveRecord
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ContactSite';
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
        return ['Url'];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return ($this->Secure == 1 ? 'https://' : 'http://').trim($this->Url, ' /');
    }
}
