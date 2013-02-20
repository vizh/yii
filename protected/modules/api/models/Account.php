<?php
namespace api\models;
/**
 * @property int $Id
 * @property string $Key
 * @property string $Secret
 * @property int $EventId
 * @property string $IpCheck
 * @property string $DataBuilder
 *
 * @property \event\models\Event $Event
 * @property Domain[] $Domains
 */
class Account extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return Account
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'ApiAccount';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'Domains' => array(self::HAS_MANY, '\api\models\Domain', 'AccountId'),
    );
  }

  /**
   * @param string $key
   * @param bool $useAnd
   *
   * @return Account
   */
  public function byKey($key, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Key" = :Key';
    $criteria->params = array(':Key' => $key);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  protected $_dataBuilder = null;

  /**
   * @return \api\components\builders\BaseDataBuilder
   */
  public function DataBuilder()
  {
    if (empty($this->_dataBuilder))
    {
      if ($this->DataBuilder == null)
      {
        $this->_dataBuilder = new \api\components\builders\BaseDataBuilder($this);
      }
      else
      {
        $class = '\api\components\builders\\' . $this->DataBuilder;
        $this->_dataBuilder = new $class($this);
      }
    }

    return $this->_dataBuilder;
  }

  public function checkIp($ip)
  {
    //todo: fix it
    return true;
  }

  /**
   * @param string $hash
   * @param int $timestamp
   * @return bool
   */
  public function CheckHash($hash, $timestamp)
  {
    if ($hash === $this->getHash($timestamp))
    {
      return true;
    }
    return false;
  }

  public function checkReferer($referer, $hash)
  {
    if ($hash !== $this->getRefererHash($referer))
    {
      return false;
    }
    foreach ($this->Domains as $domain)
    {
      $pattern = '/^' . $domain->Domain . '$/i';
      if (preg_match($pattern, $referer) === 1)
      {
        return true;
      }
    }
    return false;
  }

  public function getRefererHash($referer)
  {
    return substr(md5($this->Key . $referer . $this->Secret . 'nPOg9ODiyos4HJIYS9FGGJ7qw'), 0, 16);
  }

  /**
   * @param int $timestamp
   * @return string
   */
  private function getHash($timestamp)
  {
    return substr(md5($this->Key . $timestamp . $this->Secret), 0, 16);
  }
}