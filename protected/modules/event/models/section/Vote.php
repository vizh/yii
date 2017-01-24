<?php
namespace event\models\section;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $SectionId
 * @property int $UserId
 * @property int $SpeakerSkill
 * @property int $ReportInteresting
 * @property string $CreationTime
 *
 * Описание вспомогательных методов
 * @method Vote   with($condition = '')
 * @method Vote   find($condition = '', $params = [])
 * @method Vote   findByPk($pk, $condition = '', $params = [])
 * @method Vote   findByAttributes($attributes, $condition = '', $params = [])
 * @method Vote[] findAll($condition = '', $params = [])
 * @method Vote[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Vote byId(int $id, bool $useAnd = true)
 * @method Vote bySectionId(int $id, bool $useAnd = true)
 * @method Vote byUserId(int $id, bool $useAnd = true)
 * @method Vote bySpeakerSkill(int $skill, bool $useAnd = true)
 * @method Vote byReportInteresting(int $interesting, bool $useAnd = true)
 */
class Vote extends ActiveRecord
{
    /**
     * @param string $className
     * @return Vote
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionVote';
    }

    public function relations()
    {
        return [
            'Section' => [self::BELONGS_TO, '\event\models\section\Section', 'SectionId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        ];
    }
}