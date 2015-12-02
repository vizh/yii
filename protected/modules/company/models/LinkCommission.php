<?php
namespace company\models;
use application\components\ActiveRecord;


/**
 * This is the model class for table "CompanyLinkCommission".
 *
 * The followings are the available columns in table 'CompanyLinkCommission':
 * @property integer $CompanyId
 * @property integer $CommissionId
 *
 * @method LinkCommission byCompanyId(int $id)
 * @method LinkCommission byCommissionId(int $id)
 */
class LinkCommission extends ActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LinkCommission the static model class
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
        return 'CompanyLinkCommission';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [];
    }
}