<?php
namespace job\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 *
 * Описание вспомогательных методов
 * @method CategoryLinkPosition   with($condition = '')
 * @method CategoryLinkPosition   find($condition = '', $params = [])
 * @method CategoryLinkPosition   findByPk($pk, $condition = '', $params = [])
 * @method CategoryLinkPosition   findByAttributes($attributes, $condition = '', $params = [])
 * @method CategoryLinkPosition[] findAll($condition = '', $params = [])
 * @method CategoryLinkPosition[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method CategoryLinkPosition byId(int $id, bool $useAnd = true)
 * @method CategoryLinkPosition byTitle(string $title, bool $useAnd = true)
 */
class CategoryLinkPosition extends ActiveRecord
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
        return 'JobCategoryLinkPosition';
    }

    public function relations()
    {
        return [
            'Position' => [self::BELONGS_TO, '\job\models\Position', 'PositionId'],
        ];
    }
}
