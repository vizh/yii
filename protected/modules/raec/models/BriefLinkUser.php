<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.09.14
 * Time: 12:13
 */

namespace raec\models;
use user\models\User;


/**
 * Class BriefLinkUser
 * @package raec\models
 * @property int $Id
 * @property int $UserId
 * @property int $BriefId
 * @property int $RoleId
 * @property Brief $Brief
 * @property User $User
 */
class BriefLinkUser extends \CActiveRecord
{
    /**
     * @param string $className
     * @return BriefLinkUser
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RaecBriefLinkUser';
    }

    public function primaryKey()
    {
        return 'Id';
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