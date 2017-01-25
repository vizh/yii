<?php
namespace user\models;

use application\components\ActiveRecord;

/**
 * @property integer $Id
 * @property integer $UserId
 * @property integer $EventId
 * @property integer $ReferrerUserId
 * @property string $CreationTime
 *
 * @property User $User
 * @property User $ReferrerUser
 *
 * Описание вспомогательных методов
 * @method Referral   with($condition = '')
 * @method Referral   find($condition = '', $params = [])
 * @method Referral   findByPk($pk, $condition = '', $params = [])
 * @method Referral   findByAttributes($attributes, $condition = '', $params = [])
 * @method Referral[] findAll($condition = '', $params = [])
 * @method Referral[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Referral byId(int $id, bool $useAnd = true)
 * @method Referral byUserId(int $id, bool $useAnd = true)
 * @method Referral byEventId(int $id, bool $useAnd = true)
 * @method Referral byReferrerUserId(int $id, bool $useAnd = true)
 */
class Referral extends ActiveRecord
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
        return 'UserReferral';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'ReferrerUser' => [self::BELONGS_TO, '\user\models\User', 'ReferrerUserId'],
        ];
    }
}