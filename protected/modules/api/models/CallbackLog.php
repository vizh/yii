<?php
namespace api\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $AccountId
 * @property string $Url
 * @property string $Params
 * @property string $Response
 * @property int $ErrorCode
 * @property string $ErrorMessage
 * @property string $CreationTime
 *
 * Описание вспомогательных методов
 * @method CallbackLog   with($condition = '')
 * @method CallbackLog   find($condition = '', $params = [])
 * @method CallbackLog   findByPk($pk, $condition = '', $params = [])
 * @method CallbackLog   findByAttributes($attributes, $condition = '', $params = [])
 * @method CallbackLog[] findAll($condition = '', $params = [])
 * @method CallbackLog[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method CallbackLog byId(int $id, bool $useAnd = true)
 * @method CallbackLog byAccountId(int $id, bool $useAnd = true)
 * @method CallbackLog byUrl(string $url, bool $useAnd = true)
 * @method CallbackLog byErrorCode(int $errorCode, bool $useAnd = true)
 */
class CallbackLog extends ActiveRecord
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
        return 'ApiCallbackLog';
    }
}