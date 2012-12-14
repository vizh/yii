<?php
namespace user\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $EmailId
 *
 * @property User $User
 * @property \contact\models\Email $Email
 */
class LinkEmail extends \CActiveRecord
{
  /**
  	* @param string $className
  	* @return LinkEmail
  	*/
  	public static function model($className=__CLASS__)
  	{
  		return parent::model($className);
  	}

  	public function tableName()
  	{
  		return 'UserLinkEmail';
  	}

  	public function primaryKey()
  	{
  		return 'Id';
  	}

  	public function relations()
  	{
      return array(
        'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
        'Email' => array(self::BELONGS_TO, '\contact\models\Email', 'EmailId'),
      );
    }
}
