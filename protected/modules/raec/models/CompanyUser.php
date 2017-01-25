<?php
namespace raec\models;

use application\components\ActiveRecord;
use company\models\Company;
use user\models\User;

/**
 * @property integer $Id
 * @property integer $CompanyId
 * @property integer $UserId
 * @property integer $StatusId
 * @property string $JoinTime
 * @property string $ExitTime
 * @property bool $AllowVote
 *
 * @property Company $Company
 * @property User $User
 * @property CompanyUserStatus $Status
 *
 * Описание вспомогательных методов
 * @method CompanyUser   with($condition = '')
 * @method CompanyUser   find($condition = '', $params = [])
 * @method CompanyUser   findByPk($pk, $condition = '', $params = [])
 * @method CompanyUser   findByAttributes($attributes, $condition = '', $params = [])
 * @method CompanyUser[] findAll($condition = '', $params = [])
 * @method CompanyUser[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method CompanyUser byId(int $id, bool $useAnd = true)
 * @method CompanyUser byCompanyId(int $id, bool $useAnd = true)
 * @method CompanyUser byUserId(int $id, bool $useAnd = true)
 * @method CompanyUser byStatusId(int $id, bool $useAnd = true)
 * @method CompanyUser byAllowVote(int $id, bool $useAnd = true)
 */
class CompanyUser extends ActiveRecord
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
        return 'RaecCompanyUser';
    }

    public function relations()
    {
        return [
            'Company' => [self::BELONGS_TO, 'company\models\Company', 'CompanyId'],
            'User' => [self::BELONGS_TO, 'user\models\User', 'UserId'],
            'Status' => [self::BELONGS_TO, 'raec\models\CompanyUserStatus', 'StatusId'],
        ];
    }
}