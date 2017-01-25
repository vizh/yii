<?php
namespace user\models;

use application\components\ActiveRecord;
use contact\models\Phone;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $PhoneId
 *
 * @property User $User
 * @property Phone $Phone
 *
 * Описание вспомогательных методов
 * @method LinkPhone   with($condition = '')
 * @method LinkPhone   find($condition = '', $params = [])
 * @method LinkPhone   findByPk($pk, $condition = '', $params = [])
 * @method LinkPhone   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkPhone[] findAll($condition = '', $params = [])
 * @method LinkPhone[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkPhone byId(int $id, bool $useAnd = true)
 * @method LinkPhone byUserId(int $id, bool $useAnd = true)
 * @method LinkPhone byPhoneId(int $id, bool $useAnd = true)
 */
class LinkPhone extends ActiveRecord
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
        return 'UserLinkPhone';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Phone' => [self::BELONGS_TO, '\contact\models\Phone', 'PhoneId'],
        ];
    }
}
