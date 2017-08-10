<?php

namespace partner\models;

use application\components\ActiveRecord;
use application\components\utility\Pbkdf2;
use event\models\Event;
use JsonSerializable;
use Yii;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 * @property string $PasswordStrong
 * @property string $NoticeEmail
 *
 * @property string $Role
 * @property Event $Event
 *
 * Описание вспомогательных методов
 * @method Account   with($condition = '')
 * @method Account   find($condition = '', $params = [])
 * @method Account   findByPk($pk, $condition = '', $params = [])
 * @method Account   findByAttributes($attributes, $condition = '', $params = [])
 * @method Account[] findAll($condition = '', $params = [])
 * @method Account[] findAllByAttributes($attributes, $condition = '', $params = [])
 * @method Account byId(int $id, bool $useAnd = true)
 * @method Account byEventId(int $id, bool $useAnd = true)
 * @method Account byLogin(string $login, bool $useAnd = true)
 * @method Account byRole(string $role, bool $useAnd = true)
 */
class Account extends ActiveRecord implements JsonSerializable
{
    const ROLE_ADMIN = 'Admin';
    const ROLE_ADMIN_EXTENDED = 'AdminExtended';
    const ROLE_PARTNER = 'Partner';
    const ROLE_PARTNER_VERIFED = 'PartnerVerified';
    const ROLE_PARTNER_LIMITED = 'PartnerLimited';
    const ROLE_PARTNER_EXTENDED = 'PartnerExtended';
    const ROLE_PROGRAM = 'Program';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_STATISTICS = 'Statistics';
    const ROLE_MASS_MEDIA = 'MassMedia';
    const ROLE_APPROVE = 'Approve';
    const ROLE_EURASIA = 'Eurasia';
    const ROLE_MEETING = 'Meeting';

    /**
     * @param null|string $className
     *
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PartnerAccount';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, 'event\models\Event', 'EventId']
        ];
    }

    /**
     * Проверяет пароль партнера и обновляет хэш на безопасный
     *
     * @param string $password
     *
     * @return bool
     */
    public function checkLogin($password)
    {
        // Перевод паролей со старого типа шифрования на новый
        if ($this->PasswordStrong === null && $this->Password === md5($password)) {
            $this->Password = null;
            $this->setPassword($password);
            $this->save();

            return true;
        }

        // Собственно, валидация пароля
        return Pbkdf2::validatePassword($password, $this->PasswordStrong);
    }

    /**
     * Возвращает true, если инстанс - расширенный аккаунт для работы с любым мероприятием
     *
     * @return bool
     */
    public function getIsExtended()
    {
        return strpos($this->Role, 'Extended') !== false;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->setAttribute('PasswordStrong', (new Pbkdf2())->createHash($password));
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'Id' => $this->Id,
            'Login' => $this->Login
        ];
    }
}