<?php
namespace main\models;

use application\components\ActiveRecord;

/**
 * @property int Id
 * @property string Hash
 * @property string Url
 *
 * Описание вспомогательных методов
 * @method ShortUrl   with($condition = '')
 * @method ShortUrl   find($condition = '', $params = [])
 * @method ShortUrl   findByPk($pk, $condition = '', $params = [])
 * @method ShortUrl   findByAttributes($attributes, $condition = '', $params = [])
 * @method ShortUrl[] findAll($condition = '', $params = [])
 * @method ShortUrl[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ShortUrl byId(int $id, bool $useAnd = true)
 * @method ShortUrl byHash(string $hash, bool $useAnd = true)
 */
class ShortUrl extends ActiveRecord
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
        return 'ShortUrl';
    }
}

