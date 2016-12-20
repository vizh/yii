<?php
namespace api\models;

use application\hacks\AbstractHack;

/**
 * @property int $Id
 * @property string $Key
 * @property string $Secret
 * @property int $EventId
 * @property string $IpCheck
 * @property string $Role
 * @property string $RequestPhoneOnRegistration
 * @property integer $QuotaByUser
 * @property boolean $Blocked
 * @property text $BlockedReason
 *
 * @property \event\models\Event $Event
 * @property Domain[] $Domains
 * @property Ip[] $Ips
 * @property AccoutQuotaByUserLog[] $QuotaUsers
 *
 * @method Account find($condition='',$params=array())
 * @method Account findByPk($pk,$condition='',$params=array())
 * @method Account[] findAll($condition='',$params=array())
 */
class Account extends \CActiveRecord
{
    const ROLE_OWN = 'own';
    const ROLE_PARTNER = 'partner';
    const ROLE_MICROSOFT = 'microsoft';
    const ROLE_MBLT = 'mblt';
    const ROLE_MOBILE = 'mobile';
    const ROLE_PARTNER_WOC = 'partner_woc';

    /**
     * @deprecated toDo: Убрать после разрешения проблем с безопасностью
     */
    const ROLE_IRI = 'iri';

    const SelfId = 1;

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
            'Domains' => array(self::HAS_MANY, '\api\models\Domain', 'AccountId'),
            'Ips' => array(self::HAS_MANY, '\api\models\Ip', 'AccountId'),
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'QuotaUsers' => [self::HAS_MANY, '\api\models\AccoutQuotaByUserLog', 'AccountId']
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
        $criteria->params = [':Key' => $key];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    protected $_dataBuilder = null;

    /**
     * @return \api\components\builders\Builder
     */
    public function getDataBuilder()
    {
        if ($this->_dataBuilder === null)
        {
            $this->_dataBuilder = AbstractHack::getByEvent($this->Event)->getCustomDataBuilder($this)
                ?: new \api\components\builders\Builder($this);
        }

        return $this->_dataBuilder;
    }

    public function checkIp($ip)
    {
        if (empty($this->Ips)) {
            return true;
        }

        foreach ($this->Ips as $ipModel) {
            if ($ip === $ipModel->Ip) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $hash
     * @param int $timestamp
     * @return bool
     */
    public function checkHash($hash, $timestamp)
    {
        $checkHash = $this->getHash($timestamp);

        return $hash === $checkHash
           || strstr($hash, $checkHash) !== false;
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

    /**
     * Домены для внутренего использования
     * @return array
     */
    private function getInternalDomains()
    {
        return [
            RUNETID_HOST,
            'partner.' . RUNETID_HOST,
            'www.' . RUNETID_HOST,
            'www.partner.' . RUNETID_HOST,
        ];
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public function checkUrl($url)
    {
        $host = parse_url($url, PHP_URL_HOST);
        $path = parse_url($url, PHP_URL_PATH);

        /* Происходит мобильная OAuth авторизация. В таком случае
         * бэк-ссылка указывается в виде appid://mobile,
         * где appid - протокол обрабатываемый приложением. */
        if ($path === null && $host === 'mobile')
            return true;

        if ($this->Id === self::SelfId && (empty($url) || empty($host))) {
            return true;
        } elseif ($this->Id !== self::SelfId && empty($url)) {
            return false;
        }

        $domains = array_merge(\CHtml::listData($this->Domains, 'Id', 'Domain'), $this->getInternalDomains());
        foreach ($domains as $domain) {
            if ($path === '/widget/pay/auth/') {
                $query = parse_url($url, PHP_URL_QUERY);
                if (stripos($query, $domain) !== false) {
                    return true;
                }
            } elseif ($domain[0] === '*') {
                $needle = substr($domain, 2);
                if (stripos($host, $needle) !== false) {
                    return true;
                }
            } else {
                $pattern = '/^' . $domain . '$/i';
                if (preg_match($pattern, $host) === 1) {
                    return true;
                }
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
        if ($timestamp === null)
        {
            return md5($this->Key . $this->Secret);
        }
        else
        {
            return substr(md5($this->Key . $timestamp . $this->Secret), 0, 16);
        }
    }

    /**
     * Лейблы для типов ролей
     * @return array
     */
    public static function getRoleLabels()
    {
        return [
            self::ROLE_OWN => 'Собственное мероприятие',
            self::ROLE_PARTNER => 'Партнерское мероприятие',
            self::ROLE_PARTNER_WOC => 'Партнёрское мероприятие с ограничениями',
            self::ROLE_MICROSOFT => 'Мероприятие Microsoft',
            self::ROLE_MBLT => 'Мероприятие MBLT',
            self::ROLE_MOBILE => 'Мобильное приложение',
            self::ROLE_IRI => 'ИРИ'
        ];
    }

    public function block()
    {
        $this->Blocked = true;
        $this->save(false);
    }
}