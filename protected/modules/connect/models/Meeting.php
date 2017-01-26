<?php

namespace connect\models;

use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;
use event\models\UserData;
use mail\components\mailers\SESMailer;
use user\models\User;
use Yii;

/**
 * @property integer $Id
 * @property integer $CreatorId
 * @property integer $PlaceId
 * @property string $Date
 * @property integer $Type
 * @property string $CreateTime
 * @property integer $ReservationNumber
 * @property integer $Status
 *
 * @property Place $Place
 * @property User $Creator
 * @property MeetingLinkUser[] $UserLinks
 *
 * Описание вспомогательных методов
 * @method Meeting   with($condition = '')
 * @method Meeting   find($condition = '', $params = [])
 * @method Meeting   findByPk($pk, $condition = '', $params = [])
 * @method Meeting   findByAttributes($attributes, $condition = '', $params = [])
 * @method Meeting[] findAll($condition = '', $params = [])
 * @method Meeting[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Meeting byId(int $id, bool $useAnd = true)
 * @method Meeting byCreatorId(int $id, bool $useAnd = true)
 * @method Meeting byPlaceId(int $id, bool $useAnd = true)
 * @method Meeting byType(int $id, bool $useAnd = true)
 * @method Meeting byReservationNumber(int $reservationNumber, bool $useAnd = true)
 * @method Meeting byStatus(int $status, bool $useAnd = true)
 */
class Meeting extends ActiveRecord
{
    const TYPE_PRIVATE = 1;
    const TYPE_PUBLIC = 2;

    const STATUS_OPEN = 1;
    const STATUS_CANCELLED = 2;

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
        return 'ConnectMeeting';
    }

    public function relations()
    {
        return [
            'Place' => [self::BELONGS_TO, '\connect\models\Place', 'PlaceId'],
            'Creator' => [self::BELONGS_TO, '\user\models\User', 'CreatorId'],
            'UserLinks' => [self::HAS_MANY, '\connect\models\MeetingLinkUser', 'MeetingId']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Id' => '#',
            'Creator' => 'Пригласивший',
            'UserLinks' => 'Приглашенные',
            'Date' => 'Дата/время',
            'Status' => 'Статус',
            'CreateTime' => 'Дата/время создания',
            'Place.Name' => 'Место'
        ];
    }

    public static function statusLabels()
    {
        return [
            self::STATUS_OPEN => 'Активна',
            self::STATUS_CANCELLED => 'Отменена'
        ];
    }

    public function byUserId($id, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->with[] = 'UserLinks';
        $criteria->condition = '"UserLinks"."UserId" = :id';
        $criteria->params = ['id' => $id];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    public function getFileDir()
    {
        $dir = Yii::getPathOfAlias('webroot').'/files/connect';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $dir;
    }

    public function getFileUrl($absolute = false)
    {
        if (!$this->File) {
            return '';
        }
        $url = '/files/connect/'.$this->File;

        return rtrim($absolute ? Yii::app()->createAbsoluteUrl($url) : Yii::app()->createUrl($url), '/');
    }

    public function onInvite(\CEvent $event)
    {
        /** @var self $sender */
        $sender = $event->sender;
        $sender->refresh();

        $event->params['meeting'] = $this;

        $class = $this->getTranslatedMailClass(
            '\connect\components\handlers\invite',
            $event->params['user']
        );
        /** @var $mail \connect\components\handlers\invite\Base */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();

        $this->raiseEvent('onInvite', $event);
    }

    public function onAccept(\CEvent $event)
    {
        /** @var self $sender */
        $sender = $event->sender;
        $sender->refresh();

        $event->params['meeting'] = $this;

        $class = $this->getTranslatedMailClass(
            '\connect\components\handlers\accept\creator',
            $this->Creator
        );
        /** @var $mail \connect\components\handlers\accept\creator\Base */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();

        $class = $this->getTranslatedMailClass(
            '\connect\components\handlers\accept\user',
            $event->params['user']
        );
        /** @var $mail \connect\components\handlers\accept\user\Base */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();

        $this->raiseEvent('onAccept', $event);
    }

    public function onDeclineOrCancel(\CEvent $event)
    {
        /** @var self $sender */
        $sender = $event->sender;
        $sender->refresh();

        $event->params['meeting'] = $this;

        $class = $this->getTranslatedMailClass(
            '\connect\components\handlers\decline\creator',
            $this->Creator
        );
        /** @var $mail \connect\components\handlers\decline\creator\Base */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();

        $class = $this->getTranslatedMailClass(
            '\connect\components\handlers\decline\user',
            $event->params['user']
        );
        /** @var $mail \connect\components\handlers\decline\user\Base */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();

        $this->raiseEvent('onDeclineOrCancel', $event);
    }

    public function onCancelCreator(\CEvent $event)
    {
        /** @var self $sender */
        $sender = $event->sender;
        $sender->refresh();

        $event->params['meeting'] = $this;
        $event->params['user'] = $this->UserLinks[0]->User;

        $class = $this->getTranslatedMailClass(
            '\connect\components\handlers\cancelcreator\creator',
            $this->Creator
        );
        /** @var $mail \connect\components\handlers\cancelcreator\creator\Base */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();

        $class = $this->getTranslatedMailClass(
            '\connect\components\handlers\cancelcreator\user',
            $this->UserLinks[0]->User
        );
        /** @var $mail \connect\components\handlers\cancelcreator\user\Base */
        $mail = new $class(new SESMailer(), $event);
        $mail->send();

        $this->raiseEvent('onCancelCreator', $event);
    }

    public function reserveMeetingRoom()
    {
        if ($this->Place->reservationOnAcceptRequired) {
            /** @var Place $place */
            $place = $this->Place->assignRoom($this->Date);
            if (!$place) {
                throw new \Exception('Не удалось зарезервировать переговорную комнату', 4002);
            }
            $this->PlaceId = $place->Id;
            $this->save(false);
        }
    }

    protected function getUserLanguage($user)
    {
        $attrs = UserData::getDefinedAttributeValues($this->Place->Event, $user);
        $languages = ArrayHelper::getValue($attrs, 'languages', null);
        if (!$languages) {
            return 'ru';
        }
        $languages = mb_strtolower($languages);

        if (mb_strpos($languages, 'английский') !== false || mb_strpos($languages, 'english') !== false) {
            if (mb_stripos($languages, 'русский') !== false || mb_stripos($languages, 'russian') !== false) {
                return 'ru';
            } else {
                return 'en';
            }
        } else {
            return 'ru';
        }
    }

    protected function getTranslatedMailClass($namespace, User $user)
    {
        $lang = $this->getUserLanguage($user);
        $base = ucfirst($this->Place->Event->IdName);
        if ($lang == 'en') {
            return Yii::getExistClassArray($namespace, [$base.'En', $base], 'Base');
        } else {
            return Yii::getExistClassArray($namespace, [$base], 'Base');
        }
    }

    public function getStatusText()
    {
        if ($this->Type == self::TYPE_PRIVATE) {
            if ($this->Status == self::STATUS_CANCELLED) {
                return 'Отменена ('.$this->CancelResponse.')';
            } else {
                $link = $this->UserLinks[0];
                if ($link->Status == MeetingLinkUser::STATUS_SENT) {
                    return 'Отправлено';
                }
                if ($link->Status == MeetingLinkUser::STATUS_ACCEPTED) {
                    return 'Принято';
                }
                if ($link->Status == MeetingLinkUser::STATUS_DECLINED) {
                    return 'Отклонено ('.$link->Response.')';
                }
                if ($link->Status == MeetingLinkUser::STATUS_CANCELLED) {
                    return 'Отменено ('.$link->Response.')';
                }
            }
        } else {
            if ($this->Status == self::STATUS_OPEN) {
                return 'Активна';
            }
            if ($this->Status == Meeting::STATUS_CANCELLED) {
                return 'Отменена ('.$this->CancelResponse.')';
            }
        }

        return '';
    }
}