<?php
namespace user\models;

use application\components\ActiveRecord;
use event\models\Purpose;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $EventId
 * @property int $PurposeId
 *
 * @property Purpose $Purpose
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method LinkEventPurpose   with($condition = '')
 * @method LinkEventPurpose   find($condition = '', $params = [])
 * @method LinkEventPurpose   findByPk($pk, $condition = '', $params = [])
 * @method LinkEventPurpose   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkEventPurpose[] findAll($condition = '', $params = [])
 * @method LinkEventPurpose[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkEventPurpose byId(int $id, bool $useAnd = true)
 * @method LinkEventPurpose byUserId(int $id, bool $useAnd = true)
 * @method LinkEventPurpose byEventId(int $id, bool $useAnd = true)
 * @method LinkEventPurpose byPurposeId(int $id, bool $useAnd = true)
 */
class LinkEventPurpose extends ActiveRecord
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
        return 'UserLinkEventPurpose';
    }

    public function relations()
    {
        return [
            'Purpose' => [self::BELONGS_TO, '\event\models\Purpose', 'PurposeId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }
}