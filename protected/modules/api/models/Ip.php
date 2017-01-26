<?php
namespace api\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $AccountId
 * @property string $Ip
 *
 * Описание вспомогательных методов
 * @method Ip   with($condition = '')
 * @method Ip   find($condition = '', $params = [])
 * @method Ip   findByPk($pk, $condition = '', $params = [])
 * @method Ip   findByAttributes($attributes, $condition = '', $params = [])
 * @method Ip[] findAll($condition = '', $params = [])
 * @method Ip[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ExternalUser byId(int $id, $useAnd = true)
 * @method ExternalUser byAccountId(int $id, $useAnd = true)
 * @method ExternalUser byIp(string $id, $useAnd = true)
 */
class Ip extends ActiveRecord
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
        return 'ApiIP';
    }
}