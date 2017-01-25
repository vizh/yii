<?php
namespace user\models;

use application\components\ActiveRecord;
use contact\models\ServiceAccount;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $ServiceAccountId
 *
 * @property User $User
 * @property ServiceAccount $ServiceAccount
 *
 * Описание вспомогательных методов
 * @method LinkServiceAccount   with($condition = '')
 * @method LinkServiceAccount   find($condition = '', $params = [])
 * @method LinkServiceAccount   findByPk($pk, $condition = '', $params = [])
 * @method LinkServiceAccount   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkServiceAccount[] findAll($condition = '', $params = [])
 * @method LinkServiceAccount[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkServiceAccount byId(int $id, bool $useAnd = true)
 * @method LinkServiceAccount byUserId(int $id, bool $useAnd = true)
 * @method LinkServiceAccount byServiceAccountId(int $id, bool $useAnd = true)
 */
class LinkServiceAccount extends ActiveRecord
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
        return 'UserLinkServiceAccount';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'ServiceAccount' => [self::BELONGS_TO, '\contact\models\ServiceAccount', 'ServiceAccountId'],
        ];
    }
}