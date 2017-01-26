<?php
namespace news\models;

use application\components\ActiveRecord;

/**
 * @property int Id
 * @property string Title
 * @property string PreviewText
 * @property string Date
 * @property string Url
 * @property string UrlHash
 *
 * Описание вспомогательных методов
 * @method News   with($condition = '')
 * @method News   find($condition = '', $params = [])
 * @method News   findByPk($pk, $condition = '', $params = [])
 * @method News   findByAttributes($attributes, $condition = '', $params = [])
 * @method News[] findAll($condition = '', $params = [])
 * @method News[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method News byId(int $id, bool $useAnd = true)
 * @method News byUrlHash(string $hash, bool $useAnd = true)
 */
class News extends ActiveRecord
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
        return 'News';
    }

    protected function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            $this->UrlHash = md5($this->Url);
        }

        return parent::beforeSave();
    }

    private $photo = null;

    /**
     *
     * @return Photo $photo
     */
    public function getPhoto()
    {
        if ($this->photo == null) {
            $this->photo = new Photo($this);
        }

        return $this->photo;
    }
}
