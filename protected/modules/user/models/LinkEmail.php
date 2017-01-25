<?php
namespace user\models;

use application\components\ActiveRecord;
use contact\models\Email;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $EmailId
 *
 * @property User $User
 * @property Email $Email
 *
 * Описание вспомогательных методов
 * @method LinkEmail   with($condition = '')
 * @method LinkEmail   find($condition = '', $params = [])
 * @method LinkEmail   findByPk($pk, $condition = '', $params = [])
 * @method LinkEmail   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkEmail[] findAll($condition = '', $params = [])
 * @method LinkEmail[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkEmail byId(int $id, bool $useAnd = true)
 * @method LinkEmail byUserId(int $id, bool $useAnd = true)
 * @method LinkEmail byEmailId(int $id, bool $useAnd = true)
 */
class LinkEmail extends ActiveRecord
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
        return 'UserLinkEmail';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Email' => [self::BELONGS_TO, '\contact\models\Email', 'EmailId'],
        ];
    }
}
