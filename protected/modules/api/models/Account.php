<?php
namespace api\models;

use application\components\ActiveRecord;
use application\hacks\AbstractHack;
use event\models\Event;

/**
 * @property int $Id
 * @property string $Key
 * @property string $Secret
 * @property int $EventId
 * @property string $IpCheck
 * @property string $Role
 * @property string $RequestPhoneOnRegistration
 * @property integer $QuotaByUser
 * @property bool $Blocked
 * @property string $BlockedReason
 * @property string $Comment
 *
 * @property Event $Event
 * @property Domain[] $Domains
 * @property Ip[] $Ips
 * @property AccoutQuotaByUserLog[] $QuotaUsers
 *
 * Описание вспомогательных методов
 * @method Account   with($condition = '')
 * @method Account   find($condition = '', $params = [])
 * @method Account   findByPk($pk, $condition = '', $params = [])
 * @method Account   findByAttributes($attributes, $condition = '', $params = [])
 * @method Account[] findAll($condition = '', $params = [])
 * @method Account[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Account byKey(string $key, bool $useAnd = true)
 * @method Account bySecret(string $key, bool $useAnd = true)
 * @method Account byEventId(int $id, bool $useAnd = true)
 * @method Account byRole(string $role, bool $useAnd = true)
 * @method Account byBlocked(bool $blocked = true, bool $useAnd = true)
 */
class Account extends ActiveRecord
{
    const ROLE_BASE = 'base';
    const ROLE_SUPERVISOR = 'supervisor';
    const ROLE_OFFLINE = 'offline';
    const ROLE_OWN = 'own';
    const ROLE_PARTNER = 'partner';
    const ROLE_PARTNER_WOC = 'partner_woc';
    const ROLE_MICROSOFT = 'microsoft';
    const ROLE_MBLT = 'mblt';
    const ROLE_MOBILE = 'mobile';
    const ROLE_PROFIT = 'profit';

    const SELF_ID = 1;

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ApiAccount';
    }

    public function relations()
    {
        return [
            'Domains' => [self::HAS_MANY, '\api\models\Domain', 'AccountId'],
            'Ips' => [self::HAS_MANY, '\api\models\Ip', 'AccountId'],
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'QuotaUsers' => [self::HAS_MANY, '\api\models\AccoutQuotaByUserLog', 'AccountId']
        ];
    }

    protected $_dataBuilder;

    /**
     * @return \api\components\builders\Builder
     */
    public function getDataBuilder()
    {
        if ($this->_dataBuilder === null) {
            $this->_dataBuilder = AbstractHack::getByEvent($this->Event)->getCustomDataBuilder($this)
                ?: new \api\components\builders\Builder($this);
        }

        return $this->_dataBuilder;
    }

    public function checkIp($ip)
    {
        // Считаем ip-адрес корректным, если для аккаунта не задан список доверенных адресов или запрос происходит локально.
        if (empty($this->Ips)) {
            return true;
        }

        // В режиме разработки позволяем обращения к api с адреса 127.0.0.1 даже если для мероприятия определён список разрешённых адресов.
        if (YII_DEBUG && $ip === '127.0.0.1') {
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
        if ($hash === $this->getRefererHash($referer)) {
            foreach ($this->Domains as $domain) {
                $pattern = '/^'.$domain->Domain.'$/i';
                if (preg_match($pattern, $referer) === 1) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Домены для внутренего использования
     *
     * @return array
     */
    private function getInternalDomains()
    {
        return [
            RUNETID_HOST,
            'partner.'.RUNETID_HOST,
            'www.'.RUNETID_HOST,
            'www.partner.'.RUNETID_HOST,
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
        if ($path === null && $host === 'mobile') {
            return true;
        }

        if ($this->Id === self::SELF_ID && (empty($url) || empty($host))) {
            return true;
        } elseif ($this->Id !== self::SELF_ID && empty($url)) {
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
                $pattern = '/^'.$domain.'$/i';
                if (preg_match($pattern, $host) === 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getRefererHash($referer)
    {
        return substr(md5($this->Key.$referer.$this->Secret.'nPOg9ODiyos4HJIYS9FGGJ7qw'), 0, 16);
    }

    /**
     * @param int $timestamp
     * @return string
     */
    private function getHash($timestamp)
    {
        return $timestamp === null
            ? md5($this->Key.$this->Secret)
            : substr(md5($this->Key.$timestamp.$this->Secret), 0, 16);
    }

    /**
     * Список ролей и их названий. Только перечисленные тут роли можно назначать из панели управления.
     * Например self::ROLE_SUPERVISOR не дозволен для назначения, отсутствует в результате выполнения
     * данного метода, так как только разработчик имеет право генерировать такие уровни доступа.
     *
     * @return array
     */
    public static function getRoleLabels()
    {
        return [
            self::ROLE_OWN => 'Собственное мероприятие',
            self::ROLE_OFFLINE => 'Оффлайн сервисы RUVENTS',
            self::ROLE_MOBILE => 'Мобильное приложение',
            self::ROLE_PARTNER => 'Партнерское мероприятие',
            self::ROLE_PARTNER_WOC => 'Партнёрское мероприятие с ограничениями',
            self::ROLE_MICROSOFT => 'Мероприятие Microsoft',
            self::ROLE_MBLT => 'Мероприятие MBLT',
            self::ROLE_PROFIT => 'Глобальный: Программные сетки ВСЕХ мероприятий',
        ];
    }
}