<?php
namespace company\models;

use application\components\ActiveRecord;

/**
 * This is the model class for table "CompanyLinkProfessionalInterest".
 *
 * The followings are the available columns in table 'CompanyLinkProfessionalInterest':
 * @property integer $CompanyId
 * @property integer $ProfessionalInterestId
 * @property boolean $Primary
 *
 * @method LinkProfessionalInterest byCompanyId(integer $id)
 * @method LinkProfessionalInterest byProfessionalInterestId(integer $id)
 * @method LinkProfessionalInterest byPrimaryId(bool $primary)
 */
class LinkProfessionalInterest extends ActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LinkProfessionalInterest the static model class
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
        return 'CompanyLinkProfessionalInterest';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [];
    }
}