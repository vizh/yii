<?php
namespace event\models;

use \mail\components\mailers\MandrillMailer;
use user\models\User;

/**
 * @property int $Id
 * @property string $IdName
 * @property string $Title
 * @property string $Info
 * @property string $FullInfo
 * @property int $StartYear
 * @property int $StartMonth
 * @property int $StartDay
 * @property int $EndYear
 * @property int $EndMonth
 * @property int $EndDay
 * @property bool $Visible
 * @property bool $ShowOnMain
 * @property bool $External Для мероприятий, добавленных пользователями через форму на сайте - true, иначе - false
 * @property int $Approved Имеет значение только для мероприятий, добавленных пользователями, 0 - не определено, 1 - одобрено, -1 - отклонено
 * @property int $TypeId
 * @property string $LogoSource
 * @property string $CreationTime
 * @property bool $FullWidth
 * @property string $FbId Идентификатор мероприятия на Facebook. Если его нет, то мероприятие считает не опубликованным
 * @property bool $Deleted
 * @property string $DeletionTime
 * @property string $Color
 *
 * @property Part[] $Parts
 * @property \event\models\section\Section[] $Sections
 * @property LinkAddress $LinkAddress
 * @property LinkPhone[] $LinkPhones
 * @property LinkEmail[] $LinkEmails
 * @property LinkSite $LinkSite
 * @property Type $Type
 *
 * @property LinkWidget[] $Widgets
 * @property Attribute[] $Attributes
 * @property Partner[] $Partners
 *
 * @property LinkProfessionalInterest[] $LinkProfessionalInterests
 *
 *
 * @method \event\models\section\Section[] Sections()
 *
 * Attribute properties
 *
 * @property string $UrlSectionMask
 * @property string $FbPlaceId
 *
 * @property bool $PositionRequired
 * @property bool $PhoneRequired
 *
 * Вспомогательные описания методов методы
 * @method \event\models\Event find($condition='',$params=array())
 * @method \event\models\Event findByPk($pk,$condition='',$params=array())
 * @method \event\models\Event[] findAll($condition='',$params=array())
 */
class Event extends \application\models\translation\ActiveRecord implements \search\components\interfaces\ISearch
{
    protected $fileDir; // кеш, содержащий путь к файлам мероприятия. использовать только через getPath()
    protected $baseDir; // кеш, содержащий абсолютный путь к wwwroot

    /**
     * @param string $className
     * @return Event
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Event';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array(
            'Parts' => array(self::HAS_MANY, '\event\models\Part', 'EventId'),
            'Participants' => array(self::HAS_MANY, '\event\models\Participant', 'EventId', 'with' => array('Role')),

            'Type' => array(self::BELONGS_TO, '\event\models\Type', 'TypeId'),

            'LinkAddress' => array(self::HAS_ONE, '\event\models\LinkAddress', 'EventId'),
            'LinkPhones' => array(self::HAS_MANY, '\event\models\LinkPhone', 'EventId'),
            'LinkEmails' => array(self::HAS_MANY, '\event\models\LinkEmail', 'EventId'),
            'LinkSite' => array(self::HAS_ONE, '\event\models\LinkSite', 'EventId'),
            'Sections' => array(self::HAS_MANY, '\event\models\section\Section', 'EventId', 'order' => '"Sections"."StartTime" ASC, "Sections"."EndTime" ASC'),
            'Halls' => array(self::HAS_MANY, '\event\models\section\Hall', 'EventId', 'order' => '"Halls"."Order" ASC'),

            'Widgets' => array(self::HAS_MANY, '\event\models\LinkWidget', 'EventId', 'order' => '"Widgets"."Order" ASC', 'with' => 'Class'),
            'Attributes' => array(self::HAS_MANY, '\event\models\Attribute', 'EventId'),

            'Partners' => array(self::HAS_MANY, '\event\models\Partner', 'EventId'),

            'LinkProfessionalInterests' => array(self::HAS_MANY, '\event\models\LinkProfessionalInterest', 'EventId', 'with' => 'ProfessionalInterest')
        );
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return array('Title', 'Info', 'FullInfo');
    }

    /**
     * @return string[]
     */
    protected function getInternalAttributeNames()
    {
        return ['UrlSectionMask', 'FbPlaceId', 'Free', 'Top', 'ContactPerson', 'MailRegister', 'PositionRequired', 'PhoneRequired'];
    }

    public function __get($name)
    {
        if (in_array($name, $this->getInternalAttributeNames()))
        {
            $attribute = $this->getAttribute($name);
            if (is_array($attribute))
            {
                throw new \application\components\Exception('Работа с массивами в компоненте еще не реализована. Обращение к полю ' . $name);
            }
            elseif ($attribute === null)
            {
                throw new \application\components\Exception('У мероприятия не задан аттрибут ' . $name);
            }
            else
            {
                return $attribute->Value;
            }
        }
        else
        {
            return parent::__get($name);
        }
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->getInternalAttributeNames()))
        {
            $attribute = $this->getAttribute($name);
            if ($attribute == null)
            {
                $attribute = new Attribute();
                $attribute->Name = $name;
                $attribute->EventId = $this->Id;
                $this->internalAttributesByName[$name] = $attribute;
            }
            $attribute->Value = $value;
            $attribute->save();
        }
        else
        {
            parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        if (in_array($name, $this->getInternalAttributeNames()))
        {
            $attribute = $this->getAttribute($name);
            return $attribute !== null;
        }
        return parent::__isset($name);
    }


    /**
     * @param string $idName
     * @param bool $useAnd
     * @return Event
     */
    public function byIdName($idName, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."IdName" = :IdName';
        $criteria->params = array('IdName' => $idName);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byType($typeId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."TypeId" = :TypeId';
        $criteria->params = ['TypeId' => intval($typeId)];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function bySearch($searchTerm, $locale = null, $useAnd = true)
    {
        $criteria = new \CDbCriteria();

        $searchTerm = trim($searchTerm);
        if (empty($searchTerm))
        {
            $criteria->addCondition('0=1');
            $this->getDbCriteria()->mergeWith($criteria, $useAnd);
            return $this;
        }
        $criteria->addCondition('"t"."Title" ILIKE :SearchTerm OR "t"."IdName" ILIKE :SearchTerm');
        $criteria->params['SearchTerm'] = '%' . \Utils::PrepareStringForLike($searchTerm) . '%';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byVisible($visible = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($visible ? '' : 'NOT ') . '"t"."Visible"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byShowOnMain($showOnMain = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($showOnMain ? '' : 'NOT ') . '"t"."ShowOnMain"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byDate($year, $month = null, $useAnd = true)
    {
        $criteriaStart = new \CDbCriteria();
        $criteriaEnd = new \CDbCriteria();
        $criteriaStart->addCondition('"t"."StartYear" = :Year');
        $criteriaEnd->addCondition('"t"."EndYear" = :Year');
        $params = array('Year' => $year);
        if ($month !== null)
        {
            $criteriaStart->addCondition('"t"."StartMonth" = :Month');
            $criteriaEnd->addCondition('"t"."EndMonth" = :Month');
            $params['Month'] = $month;
        }
        $criteriaStart->mergeWith($criteriaEnd, 'OR');
        $criteriaStart->params = $params;
        $this->getDbCriteria()->mergeWith($criteriaStart, $useAnd);
        return $this;
    }

    public function byFromDate($year, $month = 1, $day = 1, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EndYear" > :FromYear OR ("t"."EndYear" = :FromYear AND "t"."EndMonth" > :FromMonth) OR ("t"."EndYear" = :FromYear AND "t"."EndMonth" = :FromMonth AND "t"."EndDay" >= :FromDay)';
        $criteria->params = array(
            'FromYear' => $year,
            'FromMonth' => $month,
            'FromDay' => $day
        );
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byToDate($year, $month = 12, $day = 31, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."StartYear" < :ToYear OR ("t"."StartYear" = :ToYear AND "t"."StartMonth" < :ToMonth) OR ("t"."StartYear" = :ToYear AND "t"."StartMonth" = :ToMonth AND "t"."StartDay" <= :ToDay)';
        $criteria->params = array(
            'ToYear' => $year,
            'ToMonth' => $month,
            'ToDay' => $day
        );
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byDeleted($deleted = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($deleted ? '' : 'NOT ') . '"t"."Deleted"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }


//  public function byTagId($id, $useAnd = true)
//  {
//    $criteria = new \CDbCriteria();
//    $criteria->condition = '"LinkTags"."TagId" = :TagId';
//    $criteria->params = array('TagId' => $id);
//    $criteria->with = array('LinkTags' => array('together' => true));
//    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
//    return $this;
//  }


    public function registerUser(\user\models\User $user, Role $role, $usePriority = false, $message = null)
    {
        if (!empty($this->Parts))
        {
            throw new \application\components\Exception('Данное мероприятие имеет логическую разбивку. Используйте метод регистрации на конкретную часть мероприятия.');
        }
        /** @var $participant Participant */
        $participant = Participant::model()
            ->byEventId($this->Id)
            ->byUserId($user->Id)
            ->byPartId(null)->find();
        if (empty($participant))
        {
            $participant = $this->registerUserUnsafe($user, $role, null, $message);
        }
        else
        {
            $this->updateRole($participant, $role, $usePriority, $message);
        }

        return $participant;
    }

    public function registerUserOnPart(Part $part, \user\models\User $user, Role $role, $usePriority = false, $message = null)
    {
        if (empty($this->Parts))
        {
            throw new \application\components\Exception('Данное мероприятие не имеет логической разбивки. Используйте метод регистрации на все мероприятие.');
        }
        /** @var $participant Participant */
        $participant = Participant::model()
            ->byEventId($this->Id)
            ->byUserId($user->Id)
            ->byPartId($part->Id)->find();
        if (empty($participant))
        {
            $participant = $this->registerUserUnsafe($user, $role, $part, $message);
        }
        else
        {
            $this->updateRole($participant, $role, $usePriority, $message);
        }
        return $participant;
    }

    private function registerUserUnsafe(\user\models\User $user, Role $role, Part $part = null, $message = null)
    {
        $participant = new Participant();
        $participant->EventId = $this->Id;
        $participant->PartId = ($part != null) ? $part->Id : null;
        $participant->UserId = $user->Id;
        $participant->RoleId = $role->Id;
        $participant->save();

        $event = new \CModelEvent($this, ['role' => $role, 'user' => $user, 'participant' => $participant, 'message' => $message]);
        $this->onRegister($event);

        return $participant;
    }

    public function unregisterUser (\user\models\User $user, $message = null)
    {
        if (!empty($this->Parts))
        {
            throw new \application\components\Exception('Данное мероприятие имеет логическую разбивку. Используйте метод удаления участия на конкретную часть мероприятия.');
        }
        $participant = Participant::model()
            ->byEventId($this->Id)->byUserId($user->Id)->find();
        if ($participant !== null)
        {
            $this->saveRegisterLog($user, null, null, $message);
            $participant->delete();
        }
    }

    public function unregisterUserOnAllParts(\user\models\User $user, $message = null)
    {
        foreach ($this->Parts as $part)
        {
            $this->unregisterUserOnPart($part, $user, $message);
        }
    }

    public function unregisterUserOnPart(Part $part, \user\models\User $user, $message = null)
    {
        if (empty($this->Parts))
        {
            throw new \application\components\Exception('Данное мероприятие не имеет логической разбивки. Используйте метод удаления участия на все мероприятие.');
        }
        /** @var $participant Participant */
        $participant = Participant::model()
            ->byEventId($this->Id)->byUserId($user->Id)->byPartId($part->Id)->find();
        if ($participant !== null)
        {
            $this->saveRegisterLog($user, null, $part, $message);
            $participant->delete();
        }
    }

    private function updateRole(Participant $participant, Role $role, $usePriority = false, $message = null)
    {
        if ($participant->RoleId != $role->Id && (!$usePriority || $participant->Role->Priority <= $role->Priority))
        {
            $participant->RoleId = $role->Id;
            $participant->UpdateTime =  date('Y-m-d H:i:s');
            $participant->save();

            $event = new \CModelEvent($this, ['role' => $role, 'user' => $participant->User, 'participant' => $participant, 'message' => $message]);
            $this->onRegister($event);

            return true;
        }
        return false;
    }

    public $skipOnRegister = false;

    /**
     * @param \CModelEvent $event
     */
    public function onRegister($event)
    {
        $this->saveRegisterLog($event->params['user'], $event->params['role'], $event->params['participant']->Part, $event->params['message']);

        if ($this->skipOnRegister)
        {
            return;
        }

        $apiCallback = \api\components\callback\Base::getCallback($this);
        if ($apiCallback !== null)
            $apiCallback->registerOnEvent($event->params['user'], $event->params['role']);

        $mailer = new MandrillMailer();
        $sender = $event->sender;
        $class = \Yii::getExistClass('\event\components\handlers\register', ucfirst($sender->IdName), 'Base');
        /** @var \mail\components\Mail $mail */
        $mail = new $class($mailer, $event);
        $mail->send();

        $class = \Yii::getExistClass('\event\components\handlers\register\system', ucfirst($sender->IdName), 'Base');
        $mail = new $class($mailer, $event);
        $mail->send();
    }

    /**
     *
     * @param Role $role
     * @param \user\models\User $user
     * @param Part $part
     * @param string $message
     */
    private function saveRegisterLog($user, $role = null, $part = null, $message = null)
    {
        $log = new \event\models\ParticipantLog();
        $log->EventId = $this->Id;
        $log->RoleId  = $role !== null ? $role->Id : null;
        $log->UserId  = $user->Id;
        $log->PartId  = $part !== null ? $part->Id : null;
        $log->Message = !empty($message) ? $message : null;
        if (!(\Yii::app() instanceof \CConsoleApplication) && !\Yii::app()->getUser()->getIsGuest())
        {
            $log->EditorId = \Yii::app()->getUser()->getId();
        }
        $log->save();
    }

    /**
     * @param \user\models\User $user
     * @param Role $role
     * @param bool $usePriority
     *
     * @return Participant[]
     */
    public function registerUserOnAllParts(\user\models\User $user, Role $role, $usePriority = false)
    {
        $result = array();
        foreach ($this->Parts as $part)
        {
            $result[$part->Id] = $this->registerUserOnPart($part, $user, $role, $usePriority);
        }
        return $result;
    }

    /**
     * @return \contact\models\Address|null
     */
    public function getContactAddress()
    {
        return !empty($this->LinkAddress) ? $this->LinkAddress->Address : null;
    }

    /**
     * @return \contact\models\Site|null
     */
    public function getContactSite()
    {
        return !empty($this->LinkSite) ? $this->LinkSite->Site : null;
    }

    /**
     * @return Role[]
     */
    public function getUsingRoles()
    {
        $criteria = new \CDbCriteria();
        $criteria->group = 't.RoleId';
        $criteria->with = array('Role');

        /** @var $participants Participant[] */
        $participants = Participant::model()->byEventId($this->Id)->findAll($criteria);
        $result = array();
        foreach ($participants as $participant)
        {
            $result[] = $participant->Role;
        }
        return $result;
    }

    public function getParticipantsCount()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('User.Visible = :Visible');
        $criteria->params['Visible'] = true;
        $criteria->with = array('User');
        $criteria->group = 't.UserId';

        return Participant::model()->byEventId($this->Id)->count($criteria);
    }

    /** @var Logo */
    private $logo = null;
    /**
     * @return Logo
     */
    public function getLogo()
    {
        if ($this->logo === null)
        {
            $this->logo = new Logo($this);
        }
        return $this->logo;
    }

    /**
     * Возвращает путь к указанному файлу в папке файлов мероприятия.
     * @param string|\CUploadedFile $fileName Вернуть путь к файлу, а не просто путь к директории.
     * @param bool $absolute Вернуть абсолютный путь.
     * @return string
     */
    public function getPath($fileName = '', $absolute = false)
    {
        return $this->getDir($absolute).$fileName;
    }

    public function getDir($absolute = false, $customId = false)
    {
        if (!$this->fileDir) $this->fileDir = sprintf(\Yii::app()->params['EventDir'], $this->IdName);
        if (!$this->baseDir) $this->baseDir = \Yii::getPathOfAlias('webroot');

        $fileDir = $this->fileDir; if ($customId)
        $fileDir = sprintf(\Yii::app()->params['EventDir'], $customId);

        return implode([
            $absolute ? $this->baseDir : '',
            $fileDir
        ]);
    }

    public function addAttribute($name, $value)
    {
        $this->getInternalAttributes();
        $this->internalAttributesByName[$name] = $value;
    }


    /**
     * @param string $name
     * @return Attribute|Attribute[]|null
     */
    public function getAttribute($name)
    {
        $attributes = $this->getInternalAttributes();
        return isset($attributes[$name]) ? $attributes[$name] : null;
    }

    private $internalAttributesByName = null;
    /**
     * @return array
     */
    public function getInternalAttributes()
    {
        if ($this->internalAttributesByName === null)
        {
            $this->internalAttributesByName = array();
            foreach ($this->Attributes as $attribute)
            {
                if (!isset($this->internalAttributesByName[$attribute->Name]))
                {
                    $this->internalAttributesByName[$attribute->Name] = $attribute;
                }
                else
                {
                    if (!is_array($this->internalAttributesByName[$attribute->Name]))
                    {
                        $this->internalAttributesByName[$attribute->Name] = array($this->internalAttributesByName[$attribute->Name]);
                    }
                    $this->internalAttributesByName[$attribute->Name][] = $attribute;
                }
            }
        }

        return $this->internalAttributesByName;
    }

    public function getTimeStampStartDate()
    {
        $date = $this->StartDay.'.'.$this->StartMonth.'.'.$this->StartYear;
        return strtotime($date);
    }

    public function getTimeStampEndDate()
    {
        $date = $this->EndDay.'.'.$this->EndMonth.'.'.$this->EndYear;
        return strtotime($date);
    }

    public function getFormattedStartDate($pattern = 'dd MMMM yyyy')
    {
        return \Yii::app()->dateFormatter->format($pattern, $this->getTimeStampStartDate());
    }

    public function getFormattedEndDate($pattern = 'dd MMMM yyyy')
    {
        return \Yii::app()->dateFormatter->format($pattern, $this->getTimeStampEndDate());
    }

    public function setContactSite($url, $secure = false)
    {
        $contactSite = $this->getContactSite();
        if (empty($contactSite))
        {
            $contactSite = new \contact\models\Site();
            $contactSite->Url = $url;
            $contactSite->Secure = $secure;
            $contactSite->save();

            $linkSite = new LinkSite();
            $linkSite->EventId = $this->Id;
            $linkSite->SiteId = $contactSite->Id;
            $linkSite->save();
        }
        elseif ($contactSite->Url != $url || $contactSite->Secure != $secure)
        {
            $contactSite->Url = $url;
            $contactSite->Secure = $secure;
            $contactSite->save();
        }

        return $contactSite;
    }

    /**
     *
     * @param \contact\models\Address $address
     */
    public function setContactAddress($address)
    {
        $linkAddress = $this->LinkAddress;
        if ($linkAddress == null)
        {
            $linkAddress = new \event\models\LinkAddress();
            $linkAddress->EventId = $this->Id;
        }
        $linkAddress->AddressId = $address->Id;
        $linkAddress->save();
    }

    /**
     *
     * @param string $direct
     * @return $this
     */
    public function orderByDate($direct = 'ASC')
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."StartYear" '.$direct.', "t"."StartMonth" '.$direct.', "t"."StartDay" '.$direct.', "t"."EndYear" '.$direct.', "t"."EndMonth" '.$direct.', "t"."EndDay" '.$direct;
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

    /**
     * Переопределение данной функции необходимо что бы производить автоматическую миграцию папки с файлами
     * мероприятия при смене IdName в проекте глобально и, при этом, не заморачиваться с beforeSave, afterSave
     * и передачей параметров между ними.
     */
    public function save($runValidation = true, $attributes = null)
    {
        if (!$this->getIsNewRecord() && ($currentData = self::findByPk($this->Id)) && $currentData->IdName != $this->IdName)
            $needDirectoryMigration = $currentData->IdName;

        if (($result = parent::save($runValidation, $attributes)))
            if (isset($needDirectoryMigration) && file_exists($this->getDir(true, $needDirectoryMigration)))
                rename($this->getDir(true, $needDirectoryMigration), $this->getDir(true));

        return $result;
    }

    public function getUrl()
    {
        return \Yii::app()->createAbsoluteUrl('/event/view/index', array('idName' => $this->IdName));
    }

    /**
     * @param \user\models\User $user
     * @param Role $role
     * @param string $redirectUrl
     * @return string
     */
    public function getFastRegisterUrl($user, $role, $redirectUrl = '')
    {
        $params = [
            'runetId' => $user->RunetId,
            'eventIdName' => $this->IdName,
            'roleId' => $role->Id,
            'hash' => $this->getFastRegisterHash($user, $role)
        ];
        if (!empty($redirectUrl))
        {
            $params['redirectUrl'] = $redirectUrl;
        }
        return \Yii::app()->createAbsoluteUrl('/event/fastregister/index', $params);
    }

    /**
     * @param \user\models\User $user
     * @param Role $role
     * @return string
     */
    public function getFastRegisterHash($user, $role)
    {
        return substr(md5($this->Id.$role->Id.'NrNojcA0vDpHN40NDHkE'.$user->RunetId), 0, 16);
    }

    /**
     * Удаляем мероприятие с Facebook при удалении в базе
     * @return bool|void
     */
    public function delete()
    {
        parent::delete();
        if ($this->isFbPublish())
            $this->fbDelete();
    }

    /**
     * Определяет, опубликовано ли мероприятие на Facebook
     * @return bool
     */
    public function isFbPublish()
    {
        return !empty($this->FbId);
    }

    /**
     * Опубликовать мероприятрие на Facebook
     * @throws \CException
     */
    public function fbPublish()
    {
        if (!empty($this->FbId))
            throw new \CException('Мероприятие уже опубликовано!');

        $fbEvent = $this->makeFbEvent();
        $id = $fbEvent->publish();
        if (empty($this->FbId))
        {
            $this->FbId = $id;
            $this->save();
        }

        $fbEvent->setPicture($this->getLogo()->getOriginal(true));
    }

    /**
     * Обновить мероприятие на Facebook
     * @return bool
     */
    public function fbUpdate()
    {
        $fbEvent = $this->makeFbEvent();
        $result = $fbEvent->update();
        $fbEvent->setPicture($this->getLogo()->getOriginal(true));
        return $result;
    }

    /**
     * Удаляет мероприятие на Facebook
     * @return mixed
     * @throws \CException
     */
    public function fbDelete()
    {
        if (empty($this->FbId))
            throw new \CException('Невозможно удалить не опубликованное мероприятие!');

        $res = $this->makeFbEvent()->delete();
        $this->FbId = null;
        $this->save();
        return $res;
    }

    /**
     * Сгенерировать FbEvent
     * @return \application\components\socials\facebook\Event
     */
    private function makeFbEvent()
    {
        $fbEvent = new \application\components\socials\facebook\Event($this->FbId);
        $fbEvent->name = $this->Title;
        $fbEvent->description = $this->Info;

        $fbEvent->setStartTime($this->StartYear . '-' . $this->StartMonth . '-' . $this->StartDay);
        if ($this->StartYear != $this->EndYear || $this->StartMonth != $this->EndMonth || $this->StartDay != $this->EndDay)
            $fbEvent->setEndTime($this->EndYear . '-' . $this->EndMonth . '-' . $this->EndDay);

        $fbEvent->location = (string)$this->LinkAddress->Address;

        if (\pay\models\Product::model()->byEventId($this->Id)->count())
            $fbEvent->ticketUri = \Yii::app()->createAbsoluteUrl('/pay/cabinet/register', ['eventIdName' => $this->IdName]);

        return $fbEvent;
    }

    private $roles = null;
    /**
     * @return Role[]
     */
    public function getRoles()
    {
        if ($this->roles == null)
        {
            $command = \Yii::app()->getDb()->createCommand();
            $command->setDistinct(true);
            $roleIdList = $command->select('EventRole.Id')
                ->from('EventRole')
                ->leftJoin('EventParticipant', '"EventParticipant"."RoleId" = "EventRole"."Id"')
                ->where('"EventParticipant"."EventId" = :EventId OR "EventRole"."Base"')
                ->queryColumn(['EventId' => $this->Id]);


            $colors = [];
            $linkRoles = LinkRole::model()->byEventId($this->Id)->findAll();
            foreach ($linkRoles as $linkRole)
            {
                $roleIdList[] = $linkRole->RoleId;
                if (!empty($linkRole->Color)) {
                    $colors[$linkRole->RoleId] = $linkRole->Color;
                }
            }

            $criteria = new \CDbCriteria();
            $criteria->order = '"t"."Title" ASC';
            $criteria->addInCondition('"t"."Id"', $roleIdList);
            $this->roles = Role::model()->findAll($criteria);

            foreach ($this->roles as $key => $role) {
                if (isset($colors[$role->Id])) {
                    $this->roles[$key]->Color = $colors[$role->Id];
                }
            }
        }
        return $this->roles;
    }

    /**
     * @param User $user
     * @return UserData[]
     */
    public function getUserData(User $user)
    {
        return UserData::model()->byEventId($this->Id)->byUserId($user->Id)->byDeleted(false)->findAll();
    }
}
