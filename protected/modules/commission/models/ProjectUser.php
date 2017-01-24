<?php
namespace commission\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $ProjectId
 * @property int $UserId
 *
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method ProjectUser   with($condition = '')
 * @method ProjectUser   find($condition = '', $params = [])
 * @method ProjectUser   findByPk($pk, $condition = '', $params = [])
 * @method ProjectUser   findByAttributes($attributes, $condition = '', $params = [])
 * @method ProjectUser[] findAll($condition = '', $params = [])
 * @method ProjectUser[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ProjectUser byId(int $id, bool $useAnd = true)
 * @method ProjectUser byProjectId(int $id, bool $useAnd = true)
 * @method ProjectUser byUserId(int $id, bool $useAnd = true)
 */
class ProjectUser extends ActiveRecord
{
    /**
     * @param string $className
     * @return ProjectUser
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'CommissionProjectUser';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        ];
    }
}
