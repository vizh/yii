<?php
namespace raec\models;
use application\components\ActiveRecord;

/**
 * This is the model class for table "RaecCompanyUserStatus".
 *
 * The followings are the available columns in table 'RaecCompanyUserStatus':
 * @property integer $Id
 * @property string $Title
 *
 * The followings are the available model relations:
 * @property CompanyUser[] $CompanyUsers
 */
class CompanyUserStatus extends ActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CompanyUserStatus the static model class
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
        return 'RaecCompanyUserStatus';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'CompanyUsers' => [self::HAS_MANY, 'RaecCompanyUser', 'StatusId'],
        ];
    }
}