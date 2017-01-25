<?php
namespace partner\models;

use application\components\ActiveRecord;
use event\models\Event;
use Yii;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 * @property string $PasswordStrong
 * @property string $NoticeEmail
 * @property string $Role
 *
 * @property Event $Event
 *
 * Описание вспомогательных методов
 * @method Account   with($condition = '')
 * @method Account   find($condition = '', $params = [])
 * @method Account   findByPk($pk, $condition = '', $params = [])
 * @method Account   findByAttributes($attributes, $condition = '', $params = [])
 * @method Account[] findAll($condition = '', $params = [])
 * @method Account[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Account byId(int $id, bool $useAnd = true)
 * @method Account byEventId(int $id, bool $useAnd = true)
 */
class Account extends ActiveRecord
{
    /**
     * @param string $className
     * @return Account
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
     * @return bool
     */
    public function checkLogin($password)
    {
        if ($this->PasswordStrong === null) {
            $lightHash = md5($password);
            if ($this->Password == $lightHash) {
                $pbkdf2 = new \application\components\utility\Pbkdf2();
                $this->PasswordStrong = $pbkdf2->createHash($password);
                $this->Password = null;
                $this->save();

                return true;
            } else {
                return false;
            }
        } else {
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
        if (empty($this->notifier)) {
            $this->notifier = new \partner\components\Notifier($this);
        }

        return $this->notifier;
    }

    public function getIsAdmin()
    {
        return strstr(Yii::app()->partner->getAccount()->Role, 'Admin') !== false;
    }

    /**
     * Возвращает true, если инстанс - расширенный аккаунт для работы с любым мероприятием
     *
     * @return bool
     */
    public function getIsExtended()
    {
        return strstr(Yii::app()->partner->getAccount()->Role, 'Extended') !== false;
    }
}