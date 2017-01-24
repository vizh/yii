<?php
namespace api\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $AccountId
 * @property string $Domain
 *
 * Описание вспомогательных методов
 * @method Domain   with($condition = '')
 * @method Domain   find($condition = '', $params = [])
 * @method Domain   findByPk($pk, $condition = '', $params = [])
 * @method Domain   findByAttributes($attributes, $condition = '', $params = [])
 * @method Domain[] findAll($condition = '', $params = [])
 * @method Domain[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Domain byId(int $id, bool $useAnd = true)
 * @method Domain byAccountId(int $id, bool $useAnd = true)
 * @method Domain byDomain(string $domain, bool $useAnd = true)
 */
class Domain extends ActiveRecord
{
    /**
     * @param string $className
     *
     * @return CallbackLog
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ApiDomain';
    }
}