<?php
namespace event\models\section;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $SectionId
 * @property string $Name
 * @property string $Value
 *
 * @property Section $Section
 */
class Attribute extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'EventSectionAttribute';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Section' => [self::BELONGS_TO, '\event\models\section\Section', 'SectionId']
        ];
    }

    public function byName($name, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Name" = :Name';
        $criteria->params = array('Name' => $name);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function bySectionId($sectionId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."SectionId" = :SectionId';
        $criteria->params = array('SectionId' => $sectionId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}
