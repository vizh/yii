<?php
AutoLoader::Import('library.rocid.api.builders.*');

/**
 * @property int $AccountId
 * @property string $ApiKey
 * @property string $SecretKey
 * @property int $EventId
 * @property string $IpList
 * @property string $DataBuilder
 *
 * @property Event $Event
 */
class ApiAccount extends CActiveRecord
{
  public static $TableName = 'Mod_ApiAccount';

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return self::$TableName;
  }

  public function primaryKey()
  {
    return 'AccountId';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, 'Event', 'EventId')
    );
  }

  protected $_dataBuilder = null;

  /**
   * @return BaseDataBuilder
   */
  public function DataBuilder()
  {
    if (empty($this->_dataBuilder))
    {
      if ($this->DataBuilder == null)
      {
        $this->_dataBuilder = new BaseDataBuilder($this);
      }
      else
      {
        $class = $this->DataBuilder;
        $this->_dataBuilder = new $class($this);
      }
    }

    return $this->_dataBuilder;
  }

  /**
   * @param string[] $list
   */
  public function SetIpList($list)
  {
    $this->IpList = serialize($list);
  }
  public function GetIpList()
  {
    return unserialize($this->IpList);
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

  /**
   * @param string $ip
   * @return bool
   */
  public function CheckIp($ip)
  {
    return in_array($ip, $this->GetIpList());
  }

  /**
   * @param int $timestamp
   * @return string
   */
  private function getHash($timestamp)
  {
    return substr(md5($this->ApiKey . $timestamp . $this->SecretKey), 0, 16);
  }

  /**
   * @static
   * @param string $apiKey
   * @return ApiAccount
   */
  public static function GetByApiKey($apiKey)
  {
    return ApiAccount::model()->find('t.ApiKey = :ApiKey', array(':ApiKey' => $apiKey));
  }

  public function CheckAccess()
  {
    $deny = $this->DataBuilder()->GetDeny();
    $router = RouteRegistry::GetInstance();
    if (array_key_exists($router->GetModule(), $deny))
    {
      if ($deny[$router->GetModule()] !== null)
      {
        $deny = $deny[$router->GetModule()];
        $section = $router->GetSection();
        if (array_key_exists($section, $deny))
        {
          if ($deny[$section] !== null)
          {
            return !in_array($router->GetCommand(), $deny[$section]);
          }
          else
          {
            return false;
          }
        }
      }
      else
      {
        return false;
      }
    }

    return true;
  }
}
