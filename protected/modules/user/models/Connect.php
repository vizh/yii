<?php
namespace user\models;

/**
 * @property int $UserConnectId
 * @property int $UserId
 * @property int $ServiceTypeId
 * @property string $Hash
 *
 * @property User $User
 */
class Connect extends \CActiveRecord
{
  const TwitterId = 13;
  const FacebookId = 14;

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public static $TableName = 'UserConnect';

  public function tableName()
  {
    return self::$TableName;
  }

  public function primaryKey()
  {
    return 'UserConnectId';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
    );
  }

  /**
   * @static
   * @param int $connectId
   * @return Connect
   */
  public static function GetById($connectId)
  {
    $userConnect = Connect::model();
    return $userConnect->findByPk($connectId);
  }

  /**
   * @static
   * @param string $hash
   * @param int $typeId
   * @return Connect
   */
  public static function GetByHash($hash, $typeId)
  {
    $userConnect = Connect::model();
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.Hash = :Hash AND t.ServiceTypeId = :ServiceTypeId';

    $criteria->params = array(':Hash' => $hash, ':ServiceTypeId' => $typeId);
    return $userConnect->find($criteria);
  }

  /**
   * @static
   * @param int $userId
   * @param string $hash
   * @param int $typeId
   * @return Connect
   */
  public static function GetDublicate($userId, $hash, $typeId)
  {
    $userConnect = Connect::model();
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.ServiceTypeId = :ServiceTypeId AND ('
                           . 't.Hash = :Hash OR t.UserId = :UserId )';
    $criteria->params = array(':UserId' => $userId, ':Hash' => $hash, ':ServiceTypeId' => $typeId);
    return $userConnect->find($criteria);
  }

  /**
   * @static
   * @param int $userId
   * @param int $typeId
   * @return Connect
   */
  public static function GetByUser($userId, $typeId)
  {
    $userConnect = Connect::model();
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.ServiceTypeId = :ServiceTypeId AND t.UserId = :UserId';

    $criteria->params = array(':UserId' => $userId, ':ServiceTypeId' => $typeId);
    return $userConnect->find($criteria);
  }
}