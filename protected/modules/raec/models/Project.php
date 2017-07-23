<?php
namespace raec\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $CommissionId
 * @property string $Title
 * @property string $Description
 * @property bool $Visible
 *
 * @property ProjectUser[] $ProjectUsers
 *
 * Описание вспомогательных методов
 * @method Project   with($condition = '')
 * @method Project   find($condition = '', $params = [])
 * @method Project   findByPk($pk, $condition = '', $params = [])
 * @method Project   findByAttributes($attributes, $condition = '', $params = [])
 * @method Project[] findAll($condition = '', $params = [])
 * @method Project[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Project byId(int $id, bool $useAnd = true)
 * @method Project byCommissionId(int $id, bool $useAnd = true)
 * @method Project byTitle(string $title, bool $useAnd = true)
 * @method Project byVisible(bool $visible, bool $useAnd = true)
 */
class Project extends ActiveRecord
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
        return 'CommissionProject';
    }

    public function relations()
    {
        return [
            'Users' => [self::HAS_MANY, '\commission\models\ProjectUser', 'ProjectId'],
        ];
    }
}
