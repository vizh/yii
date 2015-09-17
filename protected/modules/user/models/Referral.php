<?php
namespace user\models;
use application\components\ActiveRecord;

/**
 * This is the model class for table "UserReferral".
 *
 * The followings are the available columns in table 'UserReferral':
 * @property integer $Id
 * @property integer $UserId
 * @property integer $ReferrerUserId
 * @property integer $EventId
 * @property string $CreationTime
 *
 * The followings are the available model relations:
 * @property User $User
 * @property User $ReferrerUser
 *
 * @method Referral byId(int $id)
 * @method Referral byUserId(int $id)
 * @method Referral byReferrerUserId(int $id)
 * @method Referral find()
 * @method Referral byEventId(int $id)
 */
class Referral extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Referral the static model class
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
		return 'UserReferral';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
			'ReferrerUser' => [self::BELONGS_TO, '\user\models\User', 'ReferrerUserId'],
		];
	}
}