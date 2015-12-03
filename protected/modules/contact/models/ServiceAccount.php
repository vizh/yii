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
        /*if ($name === 'Account')
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
        }*/
        //todo: Проверить работоспособность и вернуть код
        parent::__set($name, $value);
    }

    /** @var string */
    private $accountUrl = null;
    public function getAccountUrl()
    {
        if ($this->accountUrl === null && $this->Type->UrlMask !== null)
        {
            if ($this->Type->Id == 14 && is_numeric($this->Account))
            {
                $this->accountUrl = sprintf("http://facebook.com/profile.php?id=%d", $this->Account);
            }
            else
            {
                $this->accountUrl = sprintf($this->Type->UrlMask, $this->getCleanAccount());
            }
        }
        return $this->accountUrl;
    }

    public function getLinkTarget()
    {
        return strpos('http://', $this->getAccountUrl()) !== false ? '_blank' : null;
    }

    private $cleanAccount = null;

    /**
     * @return string
     */
    private function getCleanAccount()
    {
        if ($this->cleanAccount == null) {
            $this->cleanAccount = rtrim($this->Account, '/');
            if (strpos($this->cleanAccount, 'http') === 0) {
                $this->cleanAccount = substr($this->cleanAccount, strrpos($this->cleanAccount, '/')+1);
            }
        }
        return $this->cleanAccount;
    }

    public function __toString()
    {
        return \CHtml::link($this->getCleanAccount(), $this->getAccountUrl(), ['target' => $this->getLinkTarget()]);
    }
}