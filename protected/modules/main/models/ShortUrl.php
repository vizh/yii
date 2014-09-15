<?php
namespace main\models;
/**
 * @property int Id
 * @property string Hash
 * @property string Url
 *
 */
class ShortUrl extends \CActiveRecord
{
    /**
     * @param string $className
     * @return ShortUrl
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ShortUrl';
    }

    /**
     * @param string $hash
     * @param bool $useAnd
     * @return $this
     */
    public function byHash($hash, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Hash" = :Hash';
        $criteria->params = array('Hash' => $hash);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}

