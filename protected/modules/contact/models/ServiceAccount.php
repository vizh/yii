<?php
namespace contact\models;

/**
 * @property int $Id
 * @property int $TypeId
 * @property string $Account
 *
 * @property ServiceType $Type
 */
class ServiceAccount extends \CActiveRecord
{
  /**
   * @param string $className
   * @return ServiceAccount
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ContactServiceAccount';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'Type' => array(self::BELONGS_TO, '\contact\models\ServiceType', 'TypeId'),
    );
  }

  public function __set($name, $value)
  {
    if ($name === 'Account')
    {
      if (!empty($this->Type))
      {
        if (preg_match($this->Type->Pattern, $value, $matches) === 1)
        {
          if (!empty($matches[1]))
          {
            $value = $matches[1];
          }
          else
          {
            throw new \application\components\Exception('Неверный шаблон для данного типа аккаунта.');
          }
        }
        else
        {
          throw new \application\components\Exception('Неверный формат аккаунта.');
        }
      }
      else
      {
        throw new \application\components\Exception('Необходимо задать тип аккаунта, до установки значения аккаунта.');
      }
    }
    parent::__set($name, $value);
  }

  /** @var string */
  private $accountUrl = null;
  public function getAccountUrl()
  {
    if ($this->accountUrl === null && $this->Type->UrlMask !== null)
    {
      $this->accountUrl = sprintf($this->Type->UrlMask, $this->Account);
    }
    return $this->accountUrl;
  }

  
  public function __toString()
  {
    return '<a href="'.$this->getAccountUrl().'">'.$this->Account.'</a>';
  }
}