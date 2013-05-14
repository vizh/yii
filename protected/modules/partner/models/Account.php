<?php
namespace partner\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 * @property string $PasswordStrong
 * @property string $NoticeEmail
 * @property string $Role
 */
class Account extends \CActiveRecord
{
  /**
   * @static
   * @param string $className
   * @return Account
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PartnerAccount';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   * @return Account
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array('EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * Проверяет пароль партнера и обновляет хэш на безопасный
   * @param string $password
   * @return bool
   */
  public function checkLogin($password)
  {
    if ($this->PasswordStrong === null)
    {
      $lightHash = md5($password);
      if ($this->Password == $lightHash)
      {
        $pbkdf2 = new \application\components\utility\Pbkdf2();
        $this->PasswordStrong = $pbkdf2->createHash($password);
        $this->Password = null;
        $this->save();
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return \application\components\utility\Pbkdf2::validatePassword($password, $this->PasswordStrong);
    }
  }

  /** @var \partner\components\Notifier */
  protected $notifier = null;

  /**
   * @return null|\partner\components\Notifier
   */
  public function getNotifier()
  {
    if (empty($this->notifier))
    {
      $this->notifier = new \partner\components\Notifier($this);
    }

    return $this->notifier;
  }

  public function getIsAdmin()
  {
    return strstr(\Yii::app()->partner->getAccount()->Role, 'Admin') !== false;
  }

  /**
   * Возвращает true, если инстанс - расширенный аккаунт для работы с любым мероприятием
   * @return bool
   */
  public function getIsExtended()
  {
    return strstr(\Yii::app()->partner->getAccount()->Role, 'Extended') !== false;
  }
}