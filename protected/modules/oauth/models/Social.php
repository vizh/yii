<?php
namespace oauth\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $SocialId
 * @property string $Hash
 *
 * @property \user\models\User $User
 */
class Social extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return Social
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'OAuthSocial';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
    );
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   *
   * @return Social
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = array('UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $socialId
   * @param bool $useAnd
   *
   * @return Social
   */
  public function bySocialId($socialId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."SocialId" = :SocialId';
    $criteria->params = array('SocialId' => $socialId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $hash
   * @param bool $useAnd
   *
   * @return Social
   */
  public function byHash($hash, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Hash" = :Hash';
    $criteria->params = array('Hash' => (string)$hash);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}