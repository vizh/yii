<?php
namespace user\models;

use api\models\ExternalUser;
use application\components\db\ar\OldAttributesStorage;
use application\components\Exception;
use application\components\utility\Pbkdf2;
use application\components\utility\PhoneticSearch;
use application\components\utility\Texts;
use application\models\translation\ActiveRecord;
use application\widgets\IAutocompleteItem;
use CEvent;
use CModelEvent;
use commission\models\Commission;
use competence\models\Result;
use event\models\Participant;
use event\models\section\LinkUser;
use ict\models\User as IctUser;
use iri\models\User as IriUser;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use mail\components\mailers\SESMailer;
use ruvents\models\Badge;
use search\components\interfaces\ISearch;
use user\components\handlers\Register;
use Yii;

/**
 * @property int $Id
 * @property int $RunetId
 * @property string $LastName
 * @property string $FirstName
 * @property string $FatherName
 * @property string $Gender
 * @property string $Birthday
 * @property string $Email
 * @property string $CreationTime
 * @property string $UpdateTime
 * @property string $LastVisit
 * @property string $Password
 * @property string $OldPassword
 * @property bool $Visible
 * @property bool $Temporary
 * @property string $Language
 * @property string $PrimaryPhone
 * @property bool $PrimaryPhoneVerify
 * @property string $PrimaryPhoneVerifyTime
 * @property int $MergeUserId
 * @property string $MergeTime
 * @property string $SearchLastName
 * @property string $SearchFirstName
 * @property bool $Verified
 * @property string $PayonlineRebill
 *
 * @property LinkEmail $LinkEmail
 * @property LinkAddress $LinkAddress
 * @property LinkSite $LinkSite
 * @property LinkPhone[] $LinkPhones
 * @property LinkServiceAccount[] $LinkServiceAccounts
 * @property LinkProfessionalInterest[] $LinkProfessionalInterests
 * @property Employment[] $Employments
 * @property Education[] $Educations
 * @property Commission[] $Commissions
 * @property Participant[] $Participants
 * @property LinkUser[] $LinkSections
 * @property Settings $Settings Настройки аккаунта пользователя
 * @property Result $CompetenceResults
 * @property User $MergeUser
 * @property Badge[] $Badges
 * @property IriUser[] $IRIParticipants
 * @property IriUser[] $IRIParticipantsActive
 * @property IctUser[] $ICTParticipants
 * @property IctUser[] $ICTParticipantsActive
 * @property ExternalUser[] $ExternalAccounts
 * @property Document[] $Documents
 * @property UnsubscribeEventMail[] $UnsubscribeEventMails
 * @property UserDevice[] $Devices
 *
 * События
 * @property CEvent $onRegister
 *
 * Описание вспомогательных методов
 * @method User   with($condition = '')
 * @method User   find($condition = '', $params = [])
 * @method User   findByPk($pk, $condition = '', $params = [])
 * @method User   findByAttributes($attributes, $condition = '', $params = [])
 * @method User[] findAll($condition = '', $params = [])
 * @method User[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method User byId(int $id, bool $useAnd = true)
 * @method User byRunetId(int $id, bool $useAnd = true)
 * @method User byTemporary(bool $temporary)
 * @method User byVerified(bool $verified)
 * @method User byTranslationFields($locale, $fields, $valueSuffix = '%', $useAnd = true)
 */
class User extends ActiveRecord implements ISearch, IAutocompleteItem
{
    public $EventCount;
    use OldAttributesStorage;

    //Защита от перегрузки при поиске
    const MaxSearchFragments = 500;

    const PasswordLengthMin = 6;

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['FirstName,LastName,FatherName', 'filter', 'filter' => 'trim'],
            ['Email', 'filter', 'filter' => 'strtolower']
        ];
    }

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'User';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'LinkEmail' => [self::HAS_ONE, '\user\models\LinkEmail', 'UserId'],
            'LinkAddress' => [self::HAS_ONE, '\user\models\LinkAddress', 'UserId'],
            'LinkSite' => [self::HAS_ONE, '\user\models\LinkSite', 'UserId'],
            'LinkPhones' => [self::HAS_MANY, '\user\models\LinkPhone', 'UserId'],
            'LinkServiceAccounts' => [self::HAS_MANY, '\user\models\LinkServiceAccount', 'UserId'],
            'LinkProfessionalInterests' => [self::HAS_MANY, '\user\models\LinkProfessionalInterest', 'UserId'],

            'Employments' => [
                self::HAS_MANY,
                '\user\models\Employment',
                'UserId',
                'with' => 'Company',
                'order' => '"Employments"."Primary" DESC, "Employments"."EndYear" DESC, "Employments"."EndMonth" DESC, "Employments"."StartYear" DESC, "Employments"."StartMonth" DESC'
            ],
            'EmploymentsForCriteria' => [self::HAS_MANY, '\user\models\Employment', 'UserId'],

            'Educations' => [
                self::HAS_MANY,
                '\user\models\Education',
                'UserId',
                'with' => ['University', 'Faculty'],
                'order' => '"Educations"."EndYear" DESC'
            ],

            'Commissions' => [self::HAS_MANY, '\commission\models\User', 'UserId', 'with' => ['Commission', 'Role']],
            'CommissionsActive' => [
                self::HAS_MANY,
                '\commission\models\User',
                'UserId',
                'with' => ['Commission', 'Role'],
                'on' => '"CommissionsActive"."ExitTime" IS NULL OR "CommissionsActive"."ExitTime" > NOW()'
            ],

            'Participants' => [self::HAS_MANY, '\event\models\Participant', 'UserId'],
            'ParticipantsForCriteria' => [self::HAS_MANY, '\event\models\Participant', 'UserId'],
            'LinkSections' => [self::HAS_MANY, '\event\models\section\LinkUser', 'UserId'],

            'Badges' => [self::HAS_MANY, '\ruvents\models\Badge', 'UserId'],

            'Settings' => [self::HAS_ONE, '\user\models\Settings', 'UserId'],
            'CompetenceResults' => [self::HAS_MANY, '\competence\models\Result', 'UserId'],

            'MergeUser' => [self::BELONGS_TO, '\user\models\User', 'MergeUserId'],

            'IRIParticipants' => [self::HAS_MANY, '\iri\models\User', 'UserId', 'with' => ['Role']],
            'IRIParticipantsActive' => [
                self::HAS_MANY,
                '\iri\models\User',
                'UserId',
                'with' => ['Role'],
                'on' => '"IRIParticipantsActive"."ExitTime" IS NULL OR "IRIParticipantsActive"."ExitTime" > NOW()'
            ],

            'ICTParticipants' => [self::HAS_MANY, '\ict\models\User', 'UserId', 'with' => ['Role']],
            'ICTParticipantsActive' => [
                self::HAS_MANY,
                '\ict\models\User',
                'UserId',
                'with' => ['Role'],
                'on' => '"ICTParticipantsActive"."ExitTime" IS NULL OR "ICTParticipantsActive"."ExitTime" > NOW()'
            ],

            'ExternalAccounts' => [self::HAS_MANY, '\api\models\ExternalUser', 'UserId'],
            'Documents' => [
                self::HAS_MANY,
                '\user\models\Document',
                'UserId',
                'on' => '"Documents"."Actual"',
                'order' => '"Documents"."TypeId" ASC'
            ],

            'UnsubscribeEventMails' => [self::HAS_MANY, '\user\models\UnsubscribeEventMail', 'UserId'],
            'Devices' => [self::HAS_MANY, '\user\models\UserDevice', 'UserId']
        ];
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['LastName', 'FirstName', 'FatherName'];
    }

    /**
     * @param int[] $runetIdList
     * @param bool $useAnd
     * @return User
     */
    public function byRunetIdList($runetIdList, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."RunetId"', array_map('intval', $runetIdList));
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param string $email
     * @param bool $useAnd
     * @return User
     */
    public function byEmail($email, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Email" = :Email';
        $criteria->params = [':Email' => strtolower($email)];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param string $phone
     * @param bool $useAnd
     * @return $this
     */
    public function byPrimaryPhone($phone, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."PrimaryPhone" = :Phone AND "t"."PrimaryPhoneVerify"';
        $criteria->params = [':Phone' => Texts::getOnlyNumbers($phone)];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param string $startTime
     * @param string $endTime
     * @param bool $useAnd
     * @return User
     */
    public function byRegisterTime($startTime = null, $endTime = null, $useAnd = true)
    {
        if ($startTime == null && $endTime == null) {
            return $this;
        }
        $criteria = new \CDbCriteria();
        if ($startTime != null) {
            $criteria->addCondition('t.CreationTime >= :StartTime');
            $criteria->params['StartTime'] = $startTime;
        }
        if ($endTime != null) {
            $criteria->addCondition('t.CreationTime <= :EndTime');
            $criteria->params['EndTime'] = $endTime;
        }
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return User
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $this->getDbCriteria()->mergeWith([
            'with' => [
                'Participants' => [
                    'together' => true
                ]
            ],
            'condition' => '"Participants"."EventId" = :EventId',
            'params' => ['EventId' => $eventId]
        ], $useAnd);

        return $this;
    }

    public function byEventRole($roleIds, $useAnd = true)
    {
        $this->getDbCriteria()->with['Participants'] = [
            'together' => true,
            'with' => [
                'Role' => [
                    'together' => true
                ]
            ]
        ];
        $this->getDbCriteria()->addInCondition('"Role"."Id"', $roleIds, $useAnd ? 'and' : 'or');

        return $this;
    }

    /**
     *
     * @param bool $visible
     * @param bool $useAnd
     *
     * @return User
     */
    public function byVisible($visible = true, $useAnd = true)
    {
        $criteria = $visible
            ? ['condition' => '"t"."Visible"']
            : ['condition' => 'NOT "t"."Visible"'];

        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param string $searchTerm
     * @param string $locale
     * @param bool $useAnd
     * @param bool $useVisible
     * @param bool $useSearch
     *
     * @return User
     */
    public function bySearch($searchTerm, $locale = null, $useAnd = true, $useVisible = true)
    {
        if ($useVisible === true) {
            $this->byVisible(true);
        }

        $searchTerm = trim($searchTerm);
        if (empty($searchTerm)) {
            $criteria = new \CDbCriteria();
            $criteria->addCondition('0=1');
            $this->getDbCriteria()->mergeWith($criteria, $useAnd);

            return $this;
        }

        if (is_numeric($searchTerm) && (int)$searchTerm !== 0) {
            return $this->byRunetId($searchTerm, $useAnd);
        }

        $parts = preg_split('/[, .]/', $searchTerm, self::MaxSearchFragments, PREG_SPLIT_NO_EMPTY);
        if (is_numeric($parts[0]) && (int)$parts[0] !== 0) {
            return $this->byRunetIdList($parts, $useAnd);
        } else {
            return $this->bySearchFullName($parts, $locale, $useAnd);
        }
    }

    /**
     * @param string[] $names
     * @param string $locale
     * @param bool $useAnd
     * @throws \application\components\Exception
     * @return User
     */
    private function bySearchFullName($names, $locale = null, $useAnd = true)
    {
        $criteria = new \CDbCriteria();

        $fields = [];
        $keys = ['LastName', 'FirstName', 'FatherName'];
        foreach ($keys as $key => $field) {
            if (isset($names[$key])) {
                $fields[$field] = $names[$key];
            }
        }
        $model = new self();
        foreach (Yii::app()->params['Languages'] as $language) {
            $model->byTranslationFields($language, $fields, '%', false);
        }
        $criteria->mergeWith($model->dbCriteria, 'or');

        $search_criteria = new \CDbCriteria();
        $_names = [];
        foreach ($names as $i => $value) {
            $_names[$i] = '%'.$value.'%';
        }
        switch (count($names)) {
            case 1:
                $search_criteria->addCondition(
                    '"t"."LastName" ilike :Part0'
                );
                $search_criteria->params['Part0'] = $_names[0];
                break;

            case 2:
                $search_criteria->addCondition('
                            ("t"."LastName" ilike :Part0 AND "t"."FirstName" ilike :Part1) OR
                            ("t"."LastName" ilike :Part1 AND "t"."FirstName" ilike :Part0)
                        ');

                $search_criteria->params['Part0'] = $_names[0];
                $search_criteria->params['Part1'] = $_names[1];
                break;

            default:
                $criteria->addCondition('
                            ("t"."LastName" ilike :Part0 AND "t"."FirstName" ilike :Part1 AND "t"."FatherName" ilike :Part2)
                        ');
                $search_criteria->params['Part0'] = $_names[0];
                $search_criteria->params['Part1'] = $_names[1];
                $search_criteria->params['Part2'] = $_names[2];
        }
        $criteria->mergeWith($search_criteria, 'or');

        $search_criteria = new \CDbCriteria();
        $_names = [];
        foreach ($names as $i => $value) {
            if ($i !== 2) {
                $value = PhoneticSearch::getIndex($value);
                $_names[$i] = Texts::prepareStringForTsvector($value);
            } else {
                $_names[$i] = Texts::prepareStringForLike($value).'%';
            }
        }
        switch (count($names)) {
            case 1:
                $search_criteria->addCondition(
                    '"t"."SearchLastName" @@ to_tsquery(:SearchPart0)'
                );
                $search_criteria->params['SearchPart0'] = $_names[0];
                break;

            case 2:
                $search_criteria->addCondition('
                    ("t"."SearchLastName" @@ to_tsquery(:SearchPart0) AND "t"."SearchFirstName" @@ to_tsquery(:SearchPart1)) OR
                    ("t"."SearchLastName" @@ to_tsquery(:SearchPart1) AND "t"."SearchFirstName" @@ to_tsquery(:SearchPart0))
                ');

                $search_criteria->params['SearchPart0'] = $_names[0];
                $search_criteria->params['SearchPart1'] = $_names[1];
                break;

            default:
                $search_criteria->addCondition('
                    ("t"."SearchLastName" @@ to_tsquery(:SearchPart0) AND "t"."SearchFirstName" @@ to_tsquery(:SearchPart1) AND "t"."FatherName" ILIKE :SearchPart2)
                ');
                $search_criteria->params['SearchPart0'] = $_names[0];
                $search_criteria->params['SearchPart1'] = $_names[1];
                $search_criteria->params['SearchPart2'] = $_names[2].'%';
        }
        $criteria->mergeWith($search_criteria, 'or');

        $this->dbCriteria->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param string $name
     * @param bool|true $useAnd
     * @return $this
     */
    public function bySearchFirstName($name, $useAnd = true)
    {
        $name = PhoneticSearch::getIndex($name);

        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."SearchFirstName" @@ to_tsquery(:Name)');
        $criteria->params['Name'] = Texts::prepareStringForTsvector($name);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     *
     * @param bool $notify
     *
     * @return User
     */
    public function register($notify = true)
    {
        if (empty($this->Password)) {
            $this->Password = \Utils::GeneratePassword();
        }

        $password = $this->Password;
        $pbkdf2 = new  Pbkdf2();
        $this->Password = $pbkdf2->createHash($password);
        $this->save();
        $this->refresh();

        if ($notify) {
            $this->onRegister(new CModelEvent($this, [
                'password' => $password
            ]));
        }

        return $this;
    }

    public function onRegister($event)
    {
        /** @var \mail\components\Mail $mail */
        $mail = new Register(new SESMailer(), $event);
        $mail->send();

        $this->raiseEvent('onRegister', $event);
    }

    /**
     * Проверяет пароль пользователя и обновляет хэш - если хэш старого образца
     *
     * @param string $password
     * @return bool
     */
    public function checkLogin($password)
    {
        if (empty($this->Password)) {
            $password2 = iconv('utf-8', 'Windows-1251', $password);
            $lightHash = md5($password);
            $lightHash2 = md5($password2);
            if ($this->OldPassword == $lightHash || $this->OldPassword == $lightHash2) {
                $pbkdf2 = new \application\components\utility\Pbkdf2();
                $this->Password = $pbkdf2->createHash($password);
                $this->OldPassword = null;
                $this->save();

                return true;
            } else {
                return false;
            }
        } else {
            return \application\components\utility\Pbkdf2::validatePassword($password, $this->Password);
        }
    }

    /** @var Photo */
    private $photo;

    /**
     * Определяет наличие фотографии посетителя.
     */
    public function hasPhoto()
    {
        return is_file($this->getPhoto()->getOriginal(true));
    }

    /**
     * @return Photo
     */
    public function getPhoto()
    {
        if ($this->photo === null) {
            $this->photo = new Photo($this->RunetId);
        }

        return $this->photo;
    }

    /**
     * Добавляет пользователю адрес электронной почты
     *
     * @param string $email
     * @param bool $verified
     * @return \contact\models\Email
     */
    public function setContactEmail($email, $verified = false)
    {
        $contactEmail = $this->getContactEmail();
        if (empty($contactEmail)) {
            $contactEmail = new \contact\models\Email();
            $contactEmail->Email = $email;
            $contactEmail->Verified = $verified;
            $contactEmail->save();

            $linkEmail = new LinkEmail();
            $linkEmail->UserId = $this->Id;
            $linkEmail->EmailId = $contactEmail->Id;
            $linkEmail->save();
        } elseif ($contactEmail->Email != $email) {
            $contactEmail->Email = $email;
            $contactEmail->Verified = $verified;
            $contactEmail->save();
        }

        return $contactEmail;
    }

    /**
     * @return \contact\models\Email|null
     */
    public function getContactEmail()
    {
        return !empty($this->LinkEmail) ? $this->LinkEmail->Email : null;
    }

    /**
     * @return \contact\models\Address|null
     */
    public function getContactAddress()
    {
        return !empty($this->LinkAddress) ? $this->LinkAddress->Address : null;
    }

    /**
     *
     * @param \contact\models\Address $address
     */
    public function setContactAddress($address)
    {
        $linkAddress = $this->LinkAddress;
        if ($linkAddress == null) {
            $linkAddress = new \user\models\LinkAddress();
            $linkAddress->UserId = $this->Id;
        }
        $linkAddress->AddressId = $address->Id;
        $linkAddress->save();
    }

    /**
     * Добавляет пользователю адресс сайта
     *
     * @param string $url
     * @param bool $secure
     * @return \contact\models\Site
     */
    public function setContactSite($url, $secure = false)
    {
        $contactSite = $this->getContactSite();
        if (empty($url)) {
            if ($this->LinkSite !== null) {
                $this->LinkSite->delete();
                $contactSite->delete();
            }

            return null;
        }

        if (empty($contactSite)) {
            $contactSite = new \contact\models\Site();
            $contactSite->Url = $url;
            $contactSite->Secure = $secure;
            $contactSite->save();

            $linkSite = new LinkSite();
            $linkSite->UserId = $this->Id;
            $linkSite->SiteId = $contactSite->Id;
            $linkSite->save();
        } elseif ($contactSite->Url != $url || $contactSite->Secure != $secure) {
            $contactSite->Url = $url;
            $contactSite->Secure = $secure;
            $contactSite->save();
        }

        return $contactSite;
    }

    /**
     * @return \contact\models\Site|null
     */
    public function getContactSite()
    {
        return !empty($this->LinkSite) ? $this->LinkSite->Site : null;
    }

    /**
     * Возращает номер телефона пользователя
     *
     * @param bool $format
     * @return null|string
     */
    public function getPhone($format = true)
    {
        $phone = null;

        if (!empty($this->PrimaryPhone)) {
            $phone = $this->PrimaryPhone;
        } else {
            $contactPhone = $this->getContactPhone();
            if ($contactPhone !== null) {
                $phone = $contactPhone->Phone;
            }
        }

        if (empty($phone)) {
            return null;
        }

        if ($format) {
            try {
                $utils = PhoneNumberUtil::getInstance();

                return $utils->format($utils->parse($phone, "RU"), PhoneNumberFormat::NATIONAL);
            } catch (NumberParseException $e) {
            }
        }

        return $phone;
    }

    /**
     * @param string $type
     * @return \contact\models\Phone|null
     */
    public function getContactPhone($type = \contact\models\PhoneType::Mobile)
    {
        foreach ($this->LinkPhones as $linkPhone) {
            if ($linkPhone->Phone->Type == $type) {
                return $linkPhone->Phone;
            }
        }

        return null;
    }

    /**
     * @param string $number
     * @param string $type
     *
     * @return \contact\models\Phone|null
     */
    public function setContactPhone($number, $type = \contact\models\PhoneType::Mobile)
    {
        $isNew = false;
        $phone = $this->getContactPhone($type);
        if ($phone === null) {
            $phone = new \contact\models\Phone();
            $phone->Type = $type;
            $isNew = true;
        }
        $phone->parsePhone($number);
        $phone->save();

        if ($isNew) {
            $linkPhone = new LinkPhone();
            $linkPhone->UserId = $this->Id;
            $linkPhone->PhoneId = $phone->Id;
            $linkPhone->save();
        }

        return $phone;
    }

    /**
     * @param string $account
     * @param \contact\models\ServiceType $type
     * @return \contact\models\ServiceAccount
     */
    public function setContactServiceAccount($account, $type)
    {
        $serviceAccount = $this->getContactServiceAccount($type);
        if (empty($serviceAccount)) {
            $serviceAccount = new \contact\models\ServiceAccount();
            $serviceAccount->TypeId = $type->Id;
            $serviceAccount->Account = $account;
            $serviceAccount->save();

            $linkServiceAccount = new LinkServiceAccount();
            $linkServiceAccount->UserId = $this->Id;
            $linkServiceAccount->ServiceAccountId = $serviceAccount->Id;
            $linkServiceAccount->save();
        } else {
            $serviceAccount->Account = $account;
            $serviceAccount->save();
        }

        return $serviceAccount;
    }

    /**
     * @param \contact\models\ServiceType $type
     * @return \contact\models\ServiceAccount|null
     */
    public function getContactServiceAccount($type)
    {
        foreach ($this->LinkServiceAccounts as $link) {
            if (!empty($link->ServiceAccount) && $link->ServiceAccount->TypeId == $type->Id) {
                return $link->ServiceAccount;
            }
        }

        return null;
    }

    /**
     * Возвращает основное место работы (либо последнее место работы, если по каким то причинам основное не указано)
     *
     * @return Employment|null
     */
    public function getEmploymentPrimary()
    {
        return (!empty($this->Employments) && empty($this->Employments[0]->EndYear)) ? $this->Employments[0] : null;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        $fullName = $this->getName();
        if ($this->getIsShowFatherName()) {
            $fullName .= ' '.$this->FatherName;
        }

        return $fullName;
    }

    /**
     * @return bool
     */
    public function getIsShowFatherName()
    {
        return !empty($this->FatherName) && ($this->Settings->HideFatherName == 0);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->LastName.' '.$this->FirstName;
    }

    /**
     *
     * @return string
     */
    public function getShortName()
    {
        $name = $this->FirstName;
        if ($this->getIsShowFatherName()) {
            $name .= ' '.$this->FatherName;
        }

        return $name;
    }

    /**
     * Изменяет пароль пользователю
     *
     * @param string $password
     * @return string
     */
    public function changePassword($password = null)
    {
        if ($password == null) {
            $password = \Utils::GeneratePassword();
        }
        $pbkdf2 = new \application\components\utility\Pbkdf2();
        $this->Password = $pbkdf2->createHash($password);
        $this->save();

        return $password;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        if ($this->Birthday == null) {
            return 0;
        }
        $birthDate = new \DateTime($this->Birthday);
        $birthDateDay = $birthDate->format('j');
        $birthDateMonth = Yii::app()->locale->getMonthName($birthDate->format('n'));

        return sprintf('%d %s', $birthDateDay, $birthDateMonth);
    }

    /**
     * Уставливает место работы пользователю
     *
     * @param $companyFullName
     * @param string $position
     * @return Employment|null
     */
    public function setEmployment($companyFullName, $position = '')
    {
        $employment = new Employment();
        $employment->chageCompany($companyFullName);
        $employment->UserId = $this->Id;
        $employment->Position = $position;
        $employment->Primary = true;
        $employment->save();

        return $employment;
    }

    /**
     * Добавляет новое устройство для отправки Push уведомлений
     *
     * @param $type string тип устройства
     * @param $token string device token
     * @return UserDevice
     * @throws Exception
     */
    public function addDevice($type, $token)
    {
        $device = new UserDevice();
        $device->UserId = $this->Id;
        $device->Type = $type;
        $device->Token = $token;

        $device->save();

        return $device;
    }

    /**
     * Проверяет наличие устройства с указанным токеном у пользователя. Если указан конкретный $token, то проверяется его наличие. По-умолчанию проверяется наличие токена в принципе.
     *
     * @param null $token
     * @return boolean
     */
    public function hasDevice($token = null)
    {
        $model = UserDevice::model()
            ->byUserId($this->Id);

        if ($token !== null) {
            $model->byToken($token);
        }

        return $model->exists();
    }

    /**
     * @param bool $isTemporary
     * @return string
     */
    public function getHash($isTemporary = false)
    {
        $salt = !$isTemporary ? 'L2qLLQWpZWYcKbjharsx' : 'cJt2zUusjphYFio26N8m';

        return substr(md5($this->Id.$salt.$this->RunetId), 0, 16);
    }

    public function getRecoveryHash($date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d');
        }

        return substr(md5($date.'L2qLLQWpZWYcKbjharsx'.$this->RunetId), 0, 6);
    }

    public function checkRecoveryHash($hash)
    {
        if ($hash === $this->getRecoveryHash(date('Y-m-d'))) {
            return true;
        }

        if ($hash === $this->getRecoveryHash(date('Y-m-d', time() - 86400))) {
            return true;
        }

        return false;
    }

    /**
     * Returns the fast authorisation url
     *
     * @param string $redirectUrl
     * @param bool|false $isTemporary
     * @return string
     */
    public function getFastauthUrl($redirectUrl = '', $isTemporary = false)
    {
        $params = [
            'runetId' => $this->RunetId,
            'hash' => $this->getHash($isTemporary),
        ];

        if (!empty($redirectUrl)) {
            $params['redirectUrl'] = $redirectUrl;
        }

        if ($isTemporary) {
            $params['temporary'] = 1;
        }

        return Yii::app()->createAbsoluteUrl('/main/fastauth/index', $params);
    }

    /**
     * @return string
     */
    public function getProfileUrl()
    {
        return Yii::app()->createUrl('/user/view/index', ['runetId' => $this->RunetId]);
    }

    /**
     * @param string $hash
     *
     * @return bool
     */
    public function checkHash($hash)
    {
        return $hash === $this->getHash();
    }

    /**
     * Обновление времени последнего входа пользователя.
     * Не выполняется чаще чем раз в минуту.
     */
    public function refreshLastVisit()
    {
        if (strtotime($this->LastVisit) < time() - 60) {
            $this->LastVisit = date('Y-m-d H:i:s');
            $this->save();
        }
    }

    /**
     * Обновление времени последнего обновления данных пользователя
     *
     * @param bool $save Сохранять ли модель
     */
    public function refreshUpdateTime($save = false)
    {
        $this->UpdateTime = date('Y-m-d H:i:s');

        if ($save === true) {
            $this->save();
        }
    }

    protected function beforeSave()
    {
        $this->updateSearchIndex();

        if (false === $this->getIsNewRecord()) {
            $this->refreshUpdateTime();
            if ($this->PrimaryPhone !== $this->getOldAttributes()['PrimaryPhone']) {
                $this->PrimaryPhoneVerify = false;
                $this->PrimaryPhoneVerifyTime = null;
            }
        }

        return parent::beforeSave();
    }

    /**
     * Обновляет поисковые индексы для пользователя
     */
    public function updateSearchIndex($force = false)
    {
        $locale = $this->getLocale();
        $this->setLocale(Yii::app()->sourceLanguage);

        if (!$this->getIsNewRecord()) {
            if (!$force && $this->getOldAttributes()['FirstName'] === $this->FirstName && $this->getOldAttributes()['LastName'] === $this->LastName) {
                return;
            }
        }
        $this->SearchFirstName = new \CDbExpression('to_tsvector(\''.PhoneticSearch::getIndex($this->FirstName).'\')');
        $this->SearchLastName = new \CDbExpression('to_tsvector(\''.PhoneticSearch::getIndex($this->LastName).'\')');
        Yii::log('User #'.$this->Id.' search index changed: '
            .$this->getOldAttributes()['SearchFirstName'].' - '.$this->SearchFirstName.
            ', '
            .$this->getOldAttributes()['SearchLastName'].' - '.$this->SearchLastName.
            ' at '.PHP_EOL.
            (new Exception())->getTraceAsString(),
            \CLogger::LEVEL_PROFILE, 'user.search');

        $this->setLocale($locale);
    }

    /**
     * Абсолютная ссылка на профиль пользователя
     *
     * @return string
     */
    public function getUrl()
    {
        return Yii::app()->createAbsoluteUrl('/user/view/index', ['runetId' => $this->RunetId]);
    }

    /**
     * Абсолютная ссылка с авторизаией для подтверждения профиля пользователя
     *
     * @return string
     */
    public function getVerifyUrl()
    {
        return $this->getFastauthUrl('/user/setting/verify');
    }

    /**
     * @param mixed $value
     *
     * @return \CActiveRecord
     */
    public function byAutocompleteValue($value)
    {
        return $this->byRunetId($value);
    }

    /**
     * @return string
     */
    public function getAutocompleteData()
    {
        return $this->getFullName();
    }

    private $hasLoyaltyDiscount;

    /**
     * @return bool|null
     */
    public function hasLoyaltyDiscount()
    {
        if ($this->hasLoyaltyDiscount == null) {
            $this->hasLoyaltyDiscount = LoyaltyProgram::model()->byUserId($this->Id)->exists();
        }

        return $this->hasLoyaltyDiscount;
    }

    public function getPrimaryPhoneVerifyCode()
    {
        if (!empty($this->PrimaryPhone)) {
            $hash = md5($this->PrimaryPhone.$this->RunetId);
            $code = Texts::getOnlyNumbers($hash);
            if (strlen($code) < 5) {
                $code = str_pad($code, 5, '0');
            }

            return substr($code, 0, 5);
        }

        return null;
    }

    /**
     * Общее кол-во участников проекта
     *
     * @return int
     */
    public static function getTotalCount()
    {
        return self::model()
            ->byVerified(true)
            ->byVisible(true)
            ->count();
    }

    /**
     * Возвращает код, используемый в RUVENTS для определения пользователя
     *
     * @return string
     */
    public function getRuventsCode()
    {
        return '~RUNETID#'.$this->RunetId.'$';
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        $string = $this->getFullName();
        $employment = $this->getEmploymentPrimary();
        if ($employment !== null) {
            $string .= ' ('.$employment.')';
        }

        return $string;
    }

    /**
     * Возвращает информацию о бэйдже для мероприятия
     * @param $eventId
     * @return Badge
     */
    public function getEventBage($eventId)
    {
        return Badge::model()
            ->byEventId($eventId)
            ->byUserId($this->Id)
            ->find();
    }
}
