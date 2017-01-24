<?php
namespace event\models\section;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $HallId
 * @property int $UserId
 * @property string VisitTime
 * @property string CreationTime
 * @property int $OperatorId
 *
 * @property Hall $Hall
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method UserVisit   with($condition = '')
 * @method UserVisit   find($condition = '', $params = [])
 * @method UserVisit   findByPk($pk, $condition = '', $params = [])
 * @method UserVisit   findByAttributes($attributes, $condition = '', $params = [])
 * @method UserVisit[] findAll($condition = '', $params = [])
 * @method UserVisit[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method UserVisit byId(int $id, bool $useAnd = true)
 * @method UserVisit byHallId(int $id, bool $useAnd = true)
 * @method UserVisit byUserId(int $id, bool $useAnd = true)
 * @method UserVisit byOperatorId(int $id, bool $useAnd = true)
 */
class UserVisit extends ActiveRecord
{
    /**
     * @param string $className
     * @return UserVisit
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionUserVisit';
    }

    public function relations()
    {
        return [
            'Hall' => [self::BELONGS_TO, 'event\models\section\Hall', 'HallId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }
}