<?php
namespace user\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $ProfessionalInterestId
 *
 * @property User $User
 * @property \application\models\ProfessionalInterest $ProfessionalInterest
 */
class LinkProfessionalInterest extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkProfessionalInterest
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'UserLinkProfessionalInterest';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'ProfessionalInterest' => array(self::BELONGS_TO, '\application\models\ProfessionalInterest', 'ProfessionalInterestId'),
    );
  }
}
