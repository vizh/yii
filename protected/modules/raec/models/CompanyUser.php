<?php
namespace raec\models;
use application\components\ActiveRecord;
use company\models\Company;
use user\models\User;

/**
 * This is the model class for table "RaecCompanyUser".
 *
 * The followings are the available columns in table 'RaecCompanyUser':
 * @property integer $Id
 * @property integer $CompanyId
 * @property integer $UserId
 * @property integer $StatusId
 * @property string $JoinTime
 * @property string $ExitTime
 * @property bool $AllowVote
 *
 * The followings are the available model relations:
 * @property Company $Company
 * @property User $User
 * @property CompanyUserStatus $Status
 *
 * @method CompanyUser byUserId(int $id)
 */
class CompanyUser extends ActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CompanyUser the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'RaecCompanyUser';
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'Company' => [self::BELONGS_TO, 'company\models\Company', 'CompanyId'],
            'User' => [self::BELONGS_TO, 'user\models\User', 'UserId'],
            'Status' => [self::BELONGS_TO, 'raec\models\CompanyUserStatus', 'StatusId'],
        ];
    }
}