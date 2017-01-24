<?php
namespace event\models;

use application\components\ActiveRecord;
use application\models\ProfessionalInterest;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $UserId
 * @property int $ProfessionalInterestId
 *
 * @property Event $Event
 * @property ProfessionalInterest $ProfessionalInterest
 *
 * Описание вспомогательных методов
 * @method LinkProfessionalInterest   with($condition = '')
 * @method LinkProfessionalInterest   find($condition = '', $params = [])
 * @method LinkProfessionalInterest   findByPk($pk, $condition = '', $params = [])
 * @method LinkProfessionalInterest   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkProfessionalInterest[] findAll($condition = '', $params = [])
 * @method LinkProfessionalInterest[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkProfessionalInterest byId(int $id, bool $useAnd = true)
 * @method LinkProfessionalInterest byEventId(int $id, bool $useAnd = true)
 * @method LinkProfessionalInterest byUserId(int $id, bool $useAnd = true)
 * @method LinkProfessionalInterest byProfessionalInterestId(int $id, bool $useAnd = true)
 */
class LinkProfessionalInterest extends ActiveRecord
{
    /**
     * @param string $className
     * @return LinkProfessionalInterest
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventLinkProfessionalInterest';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'ProfessionalInterest' => [self::BELONGS_TO, '\application\models\ProfessionalInterest', 'ProfessionalInterestId'],
        ];
    }
}
