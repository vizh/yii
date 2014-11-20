<?php
namespace event\models\section;

/**
 * Class Vote
 * @package event\models\section
 *
 * @property int $Id
 * @property int $SectionId
 * @property int $UserId
 * @property int $SpeakerSkill
 * @property int $ReportInteresting
 * @property string $CreationTime
 *
 * @method Vote find($condition='',$params=array())
 * @method Vote findByPk($pk,$condition='',$params=array())
 * @method Vote[] findAll($condition='',$params=array())
 */
class Vote extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Vote
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionVote';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array(
            'Section' => [self::BELONGS_TO, '\event\models\section\Section', 'SectionId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        );
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     * @return $this
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId';
        $criteria->params = ['UserId' => $userId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int|int[] $sectionId
     * @param bool $useAnd
     * @return $this
     */
    public function bySectionId($sectionId, $useAnd = true)
    {
        if (is_numeric($sectionId)) {
            $sectionId = [$sectionId];
        }
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('t."SectionId"', $sectionId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
} 