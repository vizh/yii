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
 *
 * Описание вспомогательных методов
 * @method Attribute   with($condition = '')
 * @method Attribute   find($condition = '', $params = [])
 * @method Attribute   findByPk($pk, $condition = '', $params = [])
 * @method Attribute   findByAttributes($attributes, $condition = '', $params = [])
 * @method Attribute[] findAll($condition = '', $params = [])
 * @method Attribute[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Attribute byId(int $id, bool $useAnd = true)
 * @method Attribute bySectionId(int $id, bool $useAnd = true)
 * @method Attribute byName(string $name, bool $useAnd = true)
 */
class Attribute extends ActiveRecord
{
    /**
     * @param string $className
     * @return Attribute
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

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
}
