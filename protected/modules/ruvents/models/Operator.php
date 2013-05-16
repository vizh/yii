<?php
namespace ruvents\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 * @property string $Role
 * @property string $LastLoginTime
 * @method \ruvents\models\Operator find()
 * @method \ruvents\models\Operator findByAttributes()
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
    return 'RuventsOperator';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function getAuthHash()
  {
    return substr(md5($this->Login . $this->Password . $this->LastLoginTime . $_SERVER['REMOTE_ADDR']), 3, 16);
  }

  public function isLoginExpire()
  {
    return $this->LastLoginTime < date('Y-m-d H:i:s', time() - 24*3600);
  }

  public static function generatePasswordHash($password)
  {
    return md5($password);
  }
}