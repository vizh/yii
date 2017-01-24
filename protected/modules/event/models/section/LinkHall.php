<?php
namespace event\models\section;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $SectionId
 * @property int $HallId
 *
 * @property Section $Section
 * @property Hall $Hall
 *
 * Описание вспомогательных методов
 * @method LinkHall   with($condition = '')
 * @method LinkHall   find($condition = '', $params = [])
 * @method LinkHall   findByPk($pk, $condition = '', $params = [])
 * @method LinkHall   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkHall[] findAll($condition = '', $params = [])
 * @method LinkHall[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkHall byId(int $id, bool $useAnd = true)
 * @method LinkHall bySectionId(int $id, bool $useAnd = true)
 * @method LinkHall byHallId(int $id, bool $useAnd = true)
 */
class LinkHall extends ActiveRecord
{
    /**
     * @param string $className
     *
     * @return LinkHall
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionLinkHall';
    }

    public function relations()
    {
        return [
            'Section' => [self::BELONGS_TO, '\event\models\section\Section', 'SectionId'],
            'Hall' => [self::BELONGS_TO, '\event\models\section\Hall', 'HallId'],
        ];
    }
}
