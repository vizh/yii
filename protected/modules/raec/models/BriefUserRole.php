<?php
namespace raec\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 *
 * Описание вспомогательных методов
 * @method BriefUserRole   with($condition = '')
 * @method BriefUserRole   find($condition = '', $params = [])
 * @method BriefUserRole   findByPk($pk, $condition = '', $params = [])
 * @method BriefUserRole   findByAttributes($attributes, $condition = '', $params = [])
 * @method BriefUserRole[] findAll($condition = '', $params = [])
 * @method BriefUserRole[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method BriefUserRole byId(int $id, bool $useAnd = true)
 * @method BriefUserRole byTitle(string $title, bool $useAnd = true)
 */
class BriefUserRole extends ActiveRecord
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
        return 'RaecBriefUserRole';
    }
}