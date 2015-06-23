<?php
namespace iri\models;
use application\components\ActiveRecord;
use application\models\ProfessionalInterest;

/**
 * This is the model class for table "IriUser".
 *
 * The followings are the available columns in table 'IriUser':
 * @property integer $Id
 * @property integer $UserId
 * @property integer $RoleId
 * @property string $JoinTime
 * @property string $ExitTime
 * @property integer $ProfessionalInterestId
 *
 * The followings are the available model relations:
 * @property \user\models\User $User
 * @property Role $Role
 * @property ProfessionalInterest $ProfessionalInterest
 *
 * @method User byUserId(integer $userId)
 * @method User byRoleId(integer $roleId)
 * @method User find()
 */
class User extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'IriUser';
	}


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return [
			'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
			'Role' => [self::BELONGS_TO, '\iri\models\Role', 'RoleId'],
            'ProfessionalInterest' => [self::BELONGS_TO, '\application\models\ProfessionalInterest', 'ProfessionalInterestId']
		];
	}

    /**
     * @return string
     */
    function __toString()
    {
        $result = $this->Role->Title;
        if (!empty($this->ProfessionalInterest)) {
            $result .= ', ' . \CHtml::link($this->ProfessionalInterest->Title, 'http://ири.рф/experts/', ['target' => '_blank']);
        }
        return $result;
    }


}