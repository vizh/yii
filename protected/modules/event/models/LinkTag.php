<?php
namespace event\models;

use application\components\ActiveRecord;
use tag\models\Tag;

/**
 * @property int $Id
 * @property int TagId
 * @property int $EventId
 *
 * @property Tag $Tag
 *
 * Описание вспомогательных методов
 * @method LinkTag   with($condition = '')
 * @method LinkTag   find($condition = '', $params = [])
 * @method LinkTag   findByPk($pk, $condition = '', $params = [])
 * @method LinkTag   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkTag[] findAll($condition = '', $params = [])
 * @method LinkTag[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkTag byId(int $id, bool $useAnd = true)
 */
class LinkTag extends ActiveRecord
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
        return 'EventLinkTag';
    }

    public function relations()
    {
        return [
            'Tag' => [self::BELONGS_TO, '\tag\models\Tag', 'TagId'],
        ];
    }
}