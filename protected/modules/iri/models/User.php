<?php
namespace iri\models;
use application\components\ActiveRecord;

/**
 * This is the model class for table "IriUser".
 *
 * The followings are the available columns in table 'IriUser':
 * @property integer $Id
 * @property integer $UserId
 * @property integer $RoleId
 * @property string $JoinTime
 * @property string $ExitTime
 *
 * The followings are the available model relations:
 * @property \user\models\User $User
 * @property Role $Role
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
		];
	}
}