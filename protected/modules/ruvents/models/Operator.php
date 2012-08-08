<?php
namespace ruvents\models;

/**
 * @property int $OperatorId
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 * @property string $Role
 * @property string $LastLoginTime
 */
class Operator extends \CActiveRecord
{
  const RoleOperator = 'Operator';
  const RoleAdmin = 'Admin';

  /**
   * @static
   * @param string $className
   * @return Operator
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'Mod_RuventsOperator';
  }

  public function primaryKey()
  {
    return 'OperatorId';
  }

  /**
   * @param $login
   * @param bool $useAnd
   * @return Operator
   */
  public function byLogin($login, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.Login = :Login';
    $criteria->params = array(':Login' => $login);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $password
   * @param bool $useAnd
   * @return Operator
   */
  public function byPassword($password, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.Password = :Password';
    $criteria->params = array(':Password' => $password);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function getAuthHash()
  {
    return substr(md5($this->Login . $this->Password . $this->LastLoginTime . $_SERVER['REMOTE_ADDR']), 3, 16);
  }

  public function isLoginExpire()
  {
    return $this->LastLoginTime < date('Y-m-d H:i:s', time() - 4*3600);
  }

  public static function GeneratePasswordHash($password)
  {
    return md5($password);
  }
}