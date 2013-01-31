<?php
namespace oauth\models;

/**
 * @property int $Id
 * @property string $Token
 * @property int $UserId
 * @property int $EventId
 * @property string $CreationTime
 * @property string $DeathTime
 *
 */
class AccessToken extends \CActiveRecord
{

  /**
   * @param string $className
   * @return AccessToken
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'Mod_OAuthAccessToken';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }

  /**
   * @param string $token
   * @param bool $useAnd
   * @return AccessToken
   */
  public function byToken($token, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.Token = :Token';
    $criteria->params = array(':Token' => $token);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.UserId = :UserId';
    $criteria->params = array(':UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public function createToken($account)
  {
    $solt = substr(md5(microtime()), 0, 16);
    $token = crypt($account->ApiKey.$account->SecretKey, '$5$rounds=5000$'.$solt); 
    $token = substr($token, strrpos($token, '$')+1);
    $this->Token = $token;
    return $this;
  }
}