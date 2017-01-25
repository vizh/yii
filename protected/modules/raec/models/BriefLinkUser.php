<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.09.14
 * Time: 12:13
 */

namespace raec\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $BriefId
 * @property int $RoleId
 *
 * @property Brief $Brief
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method BriefLinkUser   with($condition = '')
 * @method BriefLinkUser   find($condition = '', $params = [])
 * @method BriefLinkUser   findByPk($pk, $condition = '', $params = [])
 * @method BriefLinkUser   findByAttributes($attributes, $condition = '', $params = [])
 * @method BriefLinkUser[] findAll($condition = '', $params = [])
 * @method BriefLinkUser[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method BriefLinkUser byId(int $id, bool $useAnd = true)
 * @method BriefLinkUser byUserId(int $id, bool $useAnd = true)
 * @method BriefLinkUser byBriefId(int $id, bool $useAnd = true)
 * @method BriefLinkUser byRoleId(int $id, bool $useAnd = true)
 */
class BriefLinkUser extends ActiveRecord
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
        return 'RaecBriefLinkUser';
    }

    public function relations()
    {
        return [
            'Brief' => [self::BELONGS_TO, '\raec\models\Brief', 'Id'],
            'User' => [self::BELONGS_TO, '\company\models\User', 'Id'],
            'Role' => [self::BELONGS_TO, '\raec\models\BriefUserRole', 'Id']
        ];
    }
}