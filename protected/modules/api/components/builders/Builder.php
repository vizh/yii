<?php
namespace api\components\builders;

use api\components\Exception;
use api\models\Account;
use api\models\AccoutQuotaByUserLog;
use api\models\ExternalUser;
use application\components\helpers\ArrayHelper;
use application\components\utility\Texts;
use application\models\paperless\Material;
use application\models\translation\ActiveRecord;
use company\models\Company;
use competence\models\Question;
use competence\models\Result;
use competence\models\Test;
use connect\models\Meeting;
use event\models\Event;
use event\models\RoleType;
use event\models\section\Favorite;
use event\models\section\Hall;
use event\models\section\LinkUser;
use event\models\UserData;
use oauth\models\Permission;
use raec\models\CompanyUser;
use user\models\Document;
use user\models\DocumentType;
use user\models\User;
use Yii;

/**
 * Методы делятся на 2 типа:
 * 1. Методы вида createXXX - создают объект с основными данными XXX, сбрасывают предыдущее заполнение объекта XXX
 * 2. Методы вида buildXXXSomething - дополняют созданный объект XXX новыми данными. Какими именно, можно понять по
 * названию Something
 */
class Builder
{
    /**
     * @var \api\models\Account
     */
    protected $account;

    /**
     * @param \api\models\Account $account
     */
    public function __construct($account)
    {
        $this->account = $account;
    }

    protected $user;

    /**
     * Набор доступных билдеров
     */
    const USER_PERSON = 'Person';
    const USER_BIRTHDAY = 'Birthday';
    const USER_EMPLOYMENT = 'Employment';
    const USER_EVENT = 'Event';
    const USER_DATA = 'Data';
    const USER_BADGE = 'Badge';
    const USER_CONTACTS = 'Contacts';
    const USER_CONTACTS_EXTENDED = 'ContactsExtended';
    const USER_ADDRESS = 'Address';
    const USER_ATTRIBUTES = 'Attributes';
    const USER_EXTERNALID = 'ExternalId';
    const USER_AUTH = 'AuthData';
    const USER_PHOTO = 'Photo';
    const USER_DEPRECATED_DATA = 'DeprecatedData';
    const USER_PARTICIPATIONS = 'Participations';
    const USER_EMPLOYMENTS = 'Employments';
    const USER_SETTINGS = 'Settings';

    /**
     * Построение схемы данных посетителя
     *
     * @param User|\raec\models\User $user
     * @param array|null $builders набор билдеров вида Builder::EMPLOYMENT или null для построения полной схемы
     * @return mixed
     */
    public function createUser($user, $builders = null)
    {
        if ($this->account->Role === Account::ROLE_PARTNER_WOC) {
            $logExists = AccoutQuotaByUserLog::model()
                ->byAccountId($this->account->Id)
                ->byUserId($user->Id)
                ->exists();

            if ($logExists === false) {
                $log = new AccoutQuotaByUserLog();
                $log->AccountId = $this->account->Id;
                $log->UserId = $user->Id;
                $log->Time = date('Y-m-d H:i:s');
                $log->save(false);
            }
        }

        $this->createBaseUser($user);

        // Строим полную схему данных посетителя если набор билдеров не определён
        if ($builders === null) {
            $builders = [
                self::USER_PERSON,
                self::USER_PHOTO,
                self::USER_DATA,
                self::USER_ATTRIBUTES,
                self::USER_EMPLOYMENT,
                self::USER_EVENT,
                self::USER_BADGE,
                self::USER_CONTACTS,
                self::USER_EXTERNALID,
                self::USER_DEPRECATED_DATA
            ];
        }

        // Строим модель данных посетителя только из указанных блоков
        foreach ($builders as $builderName) {
            $builder = "buildUser{$builderName}";
            $this->$builder($user);
        }

        return $this->user;
    }

    /**
     * @param \user\models\User|\raec\models\User $user
     * @return \stdClass
     */
    protected function createBaseUser($user)
    {
        $this->applyLocale($user);

        $this->user = new \stdClass();

        $this->user->RunetId = $user->RunetId;

        if ($this->hasPrivatePermission($user)) {
            $this->user->CreationTime = $user->CreationTime;
            $this->user->Visible = $user->Visible;
            $this->user->Verified = $user->Verified;
            $this->user->Gender = $user->Gender;
        }

        return $this->user;
    }

    /**
     * @param \user\models\User|\raec\models\User $user
     */
    protected function buildUserPerson($user)
    {
        $this->user->LastName = $user->LastName;
        $this->user->FirstName = $user->FirstName;
        $this->user->FatherName = $user->FatherName;
    }

    protected function buildUserBirthday(User $user)
    {
        $this->user->Birthday = $user->Birthday;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection
     * @return \stdClass
     */
    protected function buildUserAuthData()
    {
        $this->user->AuthCode = Texts::GenerateString(10);

        return $this->user;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection
     * @param \user\models\User|\raec\models\User $user
     * @return \stdClass
     */
    protected function buildUserData($user)
    {
        if ($this->hasPrivatePermission($user) && $this->account->EventId !== null) {
            $attributes = UserData::getDefinedAttributeValues($this->account->Event, $user);

            if (false === empty($attributes)) {
                $this->user->Attributes = $attributes;
            }
        }

        return $this->user;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection
     * @param \user\models\User|\raec\models\User $user
     * @return \stdClass
     */
    protected function buildUserContacts($user)
    {
        if ($this->hasPrivatePermission($user)) {
            $this->user->Email = $user->Email;
            $this->user->Phone = $user->getPhone(false);
            $this->user->PhoneFormatted = $user->getPhone();

            $this->user->Phones = [];
            foreach ($user->LinkPhones as $link) {
                $this->user->Phones[] = (string)$link->Phone;
            }
        }

        return $this->user;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection
     * @param \user\models\User $user
     *
     * @return \stdClass
     */
    private function buildUserContactsExtended(User $user)
    {
        if ($this->account->Role === Account::ROLE_OWN && $user->hasRelated('LinkServiceAccounts')) {
            $accounts = [];
            foreach ($user->LinkServiceAccounts as $linkServiceAccount) {
                $accounts[] = [
                    'Type' => $linkServiceAccount->ServiceAccount->Type->Title,
                    'Account' => $linkServiceAccount->ServiceAccount->Account
                ];
            }
            $this->user->ServiceAccounts = $accounts;
        }

        return $this->user;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function buildUserAddress(User $user)
    {
        if (false === in_array($this->account->Role, [Account::ROLE_SUPERVISOR, Account::ROLE_OWN])) {
            throw new Exception(104);
        }

        if ($user->LinkAddress !== null && $user->LinkAddress->Address->CityId !== 0) {
            $this->user->Address = [
                'City' => $user->LinkAddress->Address->City->Name
            ];
        }
    }

    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    protected function buildUserEmployment($user)
    {
        $employment = $user->getEmploymentPrimary();
        if ($employment !== null) {
            $this->user->Work = new \stdClass();
            $this->user->Work->Position = $employment->Position;
            $this->user->Work->Company = $this->createEmploymentCompany($employment->Company);
            if ($this->hasPrivatePermission($user)) {
                $this->user->Work->StartYear = $employment->StartYear;
                $this->user->Work->StartMonth = $employment->StartMonth;
                $this->user->Work->EndYear = $employment->EndYear;
                $this->user->Work->EndMonth = $employment->EndMonth;
            }
        }

        return $this->user;
    }

    /**
     * Генерирует информацию обо всех трудоустройствах пользователя
     *
     * @param \user\models\User $user
     *
     * @return \stdClass
     * @throws \api\components\Exception
     */
    protected function buildUserEmployments(User $user)
    {
        $employments = [];

        foreach ($user->Employments as $employment) {
            if ($employment->CompanyId !== null) {
                $employments[] = [
                    'CompanyId' => $employment->CompanyId,
                    'CompanyName' => $employment->Company->Name,
                    'Position' => $employment->Position,
                    'StartDate' => $employment->GetFormatedStartWorking('y-M'),
                    'EndDate' => $employment->GetFormatedFinishWorking('y-M')
                ];
            }
        }

        $this->user->Employments = $employments;

        return $this->user;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection
     * @param \user\models\User|\raec\models\User $user
     * @return \stdClass
     */
    protected function buildUserEvent($user)
    {
        $isOnePart = empty($this->account->Event->Parts);
        foreach ($user->Participants as $participant) {
            if ($participant->EventId == $this->account->EventId) {
                // Для оффлайн сервисов добавляем в выдачу идентификатор RFID-бейджа
                if ($this->account->Role === Account::ROLE_OFFLINE && empty($participant->BadgeUID) !== true) {
                    $this->user->BadgeUID = $participant->BadgeUID;
                }
                if ($isOnePart) {
                    $this->user->Status = new \stdClass();
                    $this->user->Status->RoleId = $participant->RoleId;
                    $this->user->Status->RoleName = $participant->Role->Title;
                    $this->user->Status->RoleTitle = $participant->Role->Title;
                    $this->user->Status->UpdateTime = $participant->UpdateTime;
                    $this->user->Status->TicketUrl = $participant->getTicketUrl();
                } else {
                    if (!isset($this->user->Status)) {
                        $this->user->Status = [];
                    }
                    $status = new \stdClass();
                    $status->PartId = $participant->PartId;
                    $status->PartTitle = $participant->Part->Title;
                    $status->RoleId = $participant->RoleId;
                    $status->RoleName = $participant->Role->Title;
                    $status->RoleTitle = $participant->Role->Title;
                    $status->UpdateTime = $participant->UpdateTime;
                    $status->TicketUrl = $participant->getTicketUrl();
                    $this->user->Status[] = $status;
                }
            }
        }

        return $this->user;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection
     * @param \user\models\User|\raec\models\User $user
     * @return
     */
    protected function buildUserBadge($user)
    {
        if (empty($this->account->Event->Parts) && !empty($this->user->Status)) {
            $this->user->Status->Registered = \ruvents\models\Badge::model()
                ->byEventId($this->account->EventId)
                ->byUserId($user->Id)
                ->exists();
        }

        return $this->user;
    }

    /**
     * @noinspection PhpUnusedPrivateMethodInspection
     * @param User|\raec\models\User $user
     * @return \stdClass
     */
    protected function buildUserAttributes($user)
    {
        if ($this->hasPrivatePermission($user)) {
            $attributes = [];

            $data = UserData::model()
                ->byEventId($this->account->EventId)
                ->byUserId($user->Id)
                ->byDeleted(false)
                ->find();

            if ($data !== null) {
                $manager = $data->getManager();
                foreach ($manager->getDefinitions() as $definition) {
                    $attributes[$definition->name] = $definition->getExportValue($manager);
                }
            }

            // Необходимо что бы пустой список атрибутов сериализовался как {}, а не как []
            $this->user->Attributes = empty($attributes)
                ? new \stdClass()
                : $attributes;
        }

        return $this->user;
    }

    protected function buildUserSettings(User $user)
    {
        if (false === in_array($this->account->Role, [Account::ROLE_SUPERVISOR, Account::ROLE_OWN, Account::ROLE_MOBILE])) {
            throw new Exception(104);
        }

        $this->user->Settings = [
            'SubscribedForMailings' => !$user->Settings->UnsubscribeAll,
            'SubscribedForPushes' => !$user->Settings->UnsubscribePush,
            'AllowProfileIndexing' => (bool)$user->Settings->IndexProfile
        ];
    }

    /**
     * @param User|\raec\models\User $user
     * @return \stdClass
     */
    protected function buildUserExternalId($user)
    {
        $extuser = ExternalUser::model()
            ->byUserId($user->Id)
            ->byAccountId($this->account->Id)
            ->find();

        if ($extuser !== null) {
            $this->user->ExternalId = $extuser->ExternalId;
        }

        return $this->user;
    }

    /**
     * @param User|\raec\models\User $user
     *
     * @return \stdClass
     */
    protected function buildUserPhoto($user)
    {
        $photo = $user->getPhoto();
        // toDo: А ведь SCHEMA тут лишняя. В целях совместимости меж http|https протоколами скорее всего надо просто '//'.RUNETID_HOST
        $prefx = SCHEMA.'://'.RUNETID_HOST;

        $this->user->Photo = (object)[
            'Small' => $prefx.$photo->get50px(),
            'Medium' => $prefx.$photo->get90px(),
            'Large' => $prefx.$photo->get200px(),
            'Original' => $prefx.$photo->getOriginal()
        ];

        return $this->user;
    }

    /**
     * @param User|\raec\models\User $user
     *
     * @return \stdClass
     */
    protected function buildUserDeprecatedData($user)
    {
        $this->user->RocId = $user->RunetId;

        return $this->user;
    }

    /**
     * @param User|\raec\models\User $user
     *
     * @return \stdClass
     * @throws \api\components\Exception
     */
    protected function buildUserParticipations($user)
    {
        // Результирующий массив, обладающий необходимой информацией об участиях посетителя
        $participations = [];
        // Собираем все мероприятия что бы потом выдать из в профиле под Events
        $events = [];
        $participationsAnalytics = [
            'Total' => 0, // общее число мероприятий к которым причастен пользователь
            'ByYear' => [],
            'ByRoleType' => [
                RoleType::NONE => 0,
                RoleType::LISTENER => 0,
                RoleType::MASTER => 0,
                RoleType::SPEAKER => 0
            ]
        ];

        // Собираем статистику участия на мероприятиях
        foreach ($user->Participants as $participation) {
            // Участия в скрытых мероприятиях не учитываются
            if ($participation->Event === null || !$participation->Event->Visible) {
                continue;
            }
            // Запоминаем мероприятие
            $events[$participation->EventId] = $this->createEvent($participation->Event);
            // Добавляем участие пользователя
            $participations[$participation->EventId] = [
                'RoleId' => $participation->Role->Id,
                'RoleName' => $participation->Role->Title,
                'RoleType' => $participation->Role->Type,
                'EventId' => $participation->Event->Id,
                'EventAlias' => $participation->Event->IdName,
                'EventName' => $participation->Event->Title,
                'EventUrl' => $participation->Event->getUrl(),
                'EventLogo' => 'http://'.RUNETID_HOST.$participation->Event->getLogo()->getOriginal(),
                'EventStartDate' => $participation->Event->getFormattedStartDate('yyyy-MM-dd')
            ];
        }

        // Собираем статистику участия в секциях мероприятий
        $sectionsParticipation = LinkUser::model()
            ->byUserId($user->Id)
            ->byDeleted(false)
            ->with(['Section' => ['with' => ['Event']], 'Role'])
            ->findAll();

        foreach ($sectionsParticipation as $participation) {
            $event = $participation->Section->Event;

            // Если пользователь уже зарегистрирован на мероприятие с другим статусом то выберем максимальный
            if (isset($participations[$event->Id])) {
                $participations[$event->Id]['RoleType'] = RoleType::compare(
                    $participations[$event->Id]['RoleType'],
                    $participation->Role->Type
                );
                // Дело сделано, идём дальше
                continue;
            }

            // Запоминаем мероприятие
            if (false === isset($events[$event->Id])) {
                $events[$event->Id] = $this->createEvent($event);
            }


            // Выбираем максимальный статус для участия
            $participations[$event->Id] = [
                'RoleId' => $participation->Role->Id,
                'RoleName' => $participation->Role->Title,
                'RoleType' => $participation->Role->Type,
                'EventId' => $event->Id,
                'EventAlias' => $event->IdName,
                'EventTitle' => $event->Title,
                'EventUrl' => $event->getUrl(),
                'EventLogo' => 'http://'.RUNETID_HOST.$event->getLogo()->getOriginal(),
                'EventStartDate' => $event->getFormattedStartDate('yyyy-MM-dd')
            ];
        }

        // Рассчёт аналитики по участиям
        foreach ($participations as $participation) {
            $participationsAnalytics['ByYear'][(int)$participation['EventStartDate']]++;
            if (RoleType::exists($participation['RoleType'])) {
                $participationsAnalytics['ByRoleType'][$participation['RoleType']]++;
            }
        }

        // Добавляем общий список участий
        $participationsAnalytics['All'] = array_values($participations);

        // Нам не нужна статистика по RoleType::NONE
        unset($participationsAnalytics['ByRoleType'][RoleType::NONE]);

        // Рассчёт общего кол-ва участий
        $participationsAnalytics['Total'] = count($participations);

        // Сортируем статистику участий по-годам, по годам :)
        ksort($participationsAnalytics['ByYear'], SORT_NUMERIC);
        $participationsAnalytics['ByYear'] = array_reverse($participationsAnalytics['ByYear'], true);

        // Отправляем результат на золото!
        $this->user->Events = array_values($events);
        $this->user->Participations = $participationsAnalytics;

        return $this->user;
    }

    protected $company;

    /**
     * @param \company\models\Company $company
     * @return \stdClass
     */
    public function createCompany(Company $company)
    {
        $this->applyLocale($company);

        $this->company = (object)[
            'Id' => $company->Id,
            'Code' => $company->Code,
            'Name' => $company->Name,
            'FullName' => $company->FullName,
            'Info' => $company->Info,
            'Logo' => [
                'Small' => 'http://'.RUNETID_HOST.$company->getLogo()->get50px(),
                'Medium' => 'http://'.RUNETID_HOST.$company->getLogo()->get90px(),
                'Large' => 'http://'.RUNETID_HOST.$company->getLogo()->get200px(),
                'Original' => 'http://'.RUNETID_HOST.$company->getLogo()->original()
            ],
            'Url' => (string)$company->getContactSite(),
            'Phone' => !empty($company->LinkPhones[0]) ? (string)$company->LinkPhones[0]->Phone : null,
            'Email' => null,
            'Address' => (string)$company->getContactAddress(),
            'EmploymentsCount' => $company->EmploymentsCount
        ];

        if (null !== ($email = $company->getContactEmail())) {
            $this->company->Email = $email->Email;
        }

        if ($this->account->Role === Account::ROLE_OWN) {
            $this->company->Cluster = $company->Cluster;
            $this->company->ClusterGroups = ArrayHelper::columnGet('Id', $company->RaecClusters);
            $this->company->OGRN = $company->OGRN;
        }

        if ($company->Cluster === Company::CLUSTER_RAEC) {
            $this->buildCompanyRaecUser($company);
        }

        return $this->company;
    }

    /**
     * @param Company $company
     * @return mixed
     */
    public function buildCompanyRaecUser(Company $company)
    {
        foreach ($company->ActiveRaecUsers as $user) {
            $this->company->RaecUsers[] = ArrayHelper::toArray($user, [
                'raec\models\CompanyUser' => [
                    'JoinTime',
                    'AllowVote',
                    'User' => function (CompanyUser $companyUser) {
                        $this->createBaseUser($companyUser->User);

                        return $this->buildUserEmployment($companyUser->User);
                    },
                    'Status',
                ]
            ]);
        }

        return $this->company;
    }

    protected $employmentCompany;

    /**
     * @param \company\models\Company $company
     * @return \stdClass
     */
    public function createEmploymentCompany(Company $company)
    {
        $this->employmentCompany = (object)ArrayHelper::toArray($company, [
            'company\models\Company' => [
                'Id',
                'Name',
            ]
        ]);

        return $this->employmentCompany;
    }

    protected $role;

    /**
     * @param \event\models\Role $role
     * @return \stdClass
     */
    public function createRole(\event\models\Role $role)
    {
        $this->applyLocale($role);

        $this->role = new \stdClass();

        $this->role->RoleId = $role->Id;
        $this->role->Name = $role->Title;
        $this->role->Priority = $role->Priority;

        return $this->role;
    }

    protected $event;

    /**
     * @param \event\models\Event $event
     * @return \stdClass
     */
    public function createEvent($event)
    {
        $this->applyLocale($event);

        $this->event = (object)[
            'EventId' => $event->Id,
            'IdName' => $event->IdName,
            'Alias' => $event->IdName,
            'Name' => $event->Title,
            'Title' => $event->Title,
            'Info' => $event->Info,
            'FullInfo' => $event->FullInfo,
            'Url' => '',
            'StartYear' => $event->StartYear,
            'StartMonth' => $event->StartMonth,
            'StartDay' => $event->StartDay,
            'EndYear' => $event->EndYear,
            'EndMonth' => $event->EndMonth,
            'EndDay' => $event->EndDay,
            'VisibleOnMain' => $event->VisibleOnMain
        ];

        if ($event->hasRelated('Type')) {
            $this->event->Type = $event->Type;
        }

        if (null !== $site = $event->getContactSite()) {
            $this->event->Url = $site->Url;
        }

        if (null !== $address = $event->getContactAddress()) {
            $this->event->Place = $address->__toString();
            $this->event->PlaceGeoPoint = array_combine(['Longitude', 'Latitude', 'Zoom'], $address->GeoPoint);

            if ($address->hasRelated('City') && null !== $city = $address->City) {
                $this->event->Address = [
                    'CityName' => $city->Name,
                    'CountryName' => $city->hasRelated('Country') ? $city->Country->Name : null,
                    'RegionName' => $city->hasRelated('Region') ? $city->Region->Name : null
                ];
            }
        }

        if ($event->getLogo()->exists()) {
            $webRoot = Yii::getPathOfAlias('webroot');
            $urlPrefix = SCHEMA.'://'.RUNETID_HOST;
            $logo = $event->getLogo();
            $this->event->Image = [
                'Mini' => $urlPrefix.$logo->getMini(),
                'MiniSize' => $this->getImageSize($webRoot.$logo->getNormal()),
                'Normal' => $urlPrefix.$logo->getNormal(),
                'NormalSize' => $this->getImageSize($webRoot.$logo->getNormal()),
                'Original' => $urlPrefix.$logo->getOriginal()
            ];
        }

        return $this->event;
    }

    private function getImageSize($path)
    {
        $size = null;
        if (file_exists($path)) {
            $key = md5($path);
            $size = Yii::app()->getCache()->get($key);
            if ($size === false) {
                $size = new \stdClass();
                $image = imagecreatefrompng($path);
                $size->Width = imagesx($image);
                $size->Height = imagesy($image);
                imagedestroy($image);
                Yii::app()->getCache()->add($key, $size, 3600 + mt_rand(10, 500));
            }
        }

        return $size;
    }

    /**
     * @param \event\models\Event $event
     * @return \stdClass
     */
    public function buildEventPlace($event)
    {
        $address = $event->getContactAddress();
        if ($address !== null) {
            $this->event->GeoPoint = $address->GeoPoint;
            $this->event->Address = $address->__toString();
        }
        if (!empty($event->FbPlaceId)) {
            $this->event->FbPlaceId = $event->FbPlaceId;
        }

        return $this->event;
    }

    /**
     * @param \event\models\Event $event
     * @return \stdClass
     */
    public function buildEventMenu($event)
    {
        $this->event->Menu = [];

        $menu = new \stdClass();
        $menu->Type = 'program';
        $menu->Title = 'Программа';
        $this->event->Menu[] = $menu;

        // $menu = new stdClass();
        // $menu->Type = 'link';
        // $menu->Title = 'Программа+';
        // $menu->Link = 'http://rocid.ru/files/test-api.htm';
        // $this->event->Menu[] = $menu;

        // $menu = new stdClass();
        // $menu->Type = 'html';
        // $menu->Title = 'Дополнительная информация';
        // $menu->Html = '<p>Это текст с дополнительной информацией о мероприятии. Тут может быть написано что угодно, но не очень много.</p><p>Если объем текста будет значительный - проще его передать как тип меню "link"</p>';
        // $this->event->Menu[] = $menu;
    }

    /**
     * @param \event\models\Event $event
     * @return \stdClass
     */
    public function BuildEventFullInfo($event)
    {
        $this->event->FullInfo = $event->FullInfo;

        return $this->event;
    }

    public function buildEventStatistics(Event $event)
    {
        $this->event->Statistics = [
            'Participants' => [
                'ByRole' => ArrayHelper::associate('RoleId', 'Count', Yii::app()->getDb()
                    ->createCommand('SELECT "RoleId", count("Id") AS "Count" FROM "EventParticipant" WHERE "EventId" = :EventId GROUP BY "RoleId"')
                    ->bindParam(':EventId', $event->Id)
                    ->queryAll())
            ]
        ];

        // Экономим запрос на общее кол-во участников
        $this->event->Statistics['Participants']['TotalCount']
            = array_sum($this->event->Statistics['Participants']['ByRole']);

        return $this->event;
    }

    protected $product;

    /**
     * @param \pay\models\Product $product
     * @param string $time
     * @return \stdClass
     */
    public function createProduct($product, $time = null)
    {
        $this->applyLocale($product);

        $this->product = new \stdClass();
        $this->product->Id = $product->Id;
        $this->product->ProductId = $product->Id;
        /** todo: deprecated **/
        $this->product->Manager = $product->ManagerName;
        $this->product->Title = $product->Title;
        $this->product->Price = $product->getPrice($time);
        $this->product->Attributes = [];
        foreach ($product->Attributes as $attribute) {
            $this->product->Attributes[$attribute->Name] = $attribute->Value;
        }

        $manager = $product->getManager();
        if ($manager->getLimit() !== null) {
            $this->product->Limit = $manager->getLimit();
            $this->product->SoldCount = $manager->getSoldCount();
        }

        return $this->product;
    }

    protected $orderItem;

    /**
     * @param \pay\components\OrderItemCollectable $item
     *
     * @return \stdClass
     */
    public function createOrderItem(\pay\components\OrderItemCollectable $item)
    {
        $this->orderItem = new \stdClass();

        $orderItem = $item->getOrderItem();

        $this->orderItem->OrderItemId = $orderItem->Id;
        /** todo: deprecated **/
        $this->orderItem->Id = $orderItem->Id;
        $this->orderItem->Product = $this->CreateProduct($orderItem->Product, $orderItem->PaidTime);

        $this->createUser($orderItem->Payer);
        $this->buildUserEmployment($orderItem->Payer);
        $this->orderItem->Payer = $this->user;

        $owner = $orderItem->ChangedOwner !== null
            ? $orderItem->ChangedOwner
            : $orderItem->Owner;

        $this->createUser($owner);
        $this->buildUserEmployment($owner);
        $this->buildUserEvent($owner);

        $this->orderItem->Owner = $this->user;

        $this->orderItem->PriceDiscount = $item->getPriceDiscount();
        $this->orderItem->Paid = $orderItem->Paid == 1;
        $this->orderItem->PaidTime = $orderItem->PaidTime;
        $this->orderItem->Booked = $orderItem->Booked;
        $this->orderItem->Deleted = $orderItem->Deleted;
        $this->orderItem->CreationTime = $orderItem->CreationTime;

        $this->orderItem->Attributes = [];
        foreach ($orderItem->Attributes as $attribute) {
            $this->orderItem->Attributes[$attribute->Name] = $attribute->Value;
        }
        $this->orderItem->Params = $this->orderItem->Attributes;
        /** todo: deprecated */

        $this->orderItem->Discount = $item->getDiscount();
        $couponActivation = $orderItem->getCouponActivation();
        $this->orderItem->CouponCode = !empty($couponActivation) && !empty($couponActivation->Coupon)
            ? $couponActivation->Coupon->Code : null;
        $this->orderItem->GroupDiscount = $item->getIsGroupDiscount();

        return $this->orderItem;
    }

    protected $commission;

    /**
     * @param \raec\models\Commission $commission
     * @return \stdClass
     */
    public function createCommision($commission)
    {
        $this->commission = new \stdClass();

        $this->commission->CommissionId = $commission->Id;
        $this->commission->Title = $commission->Title;
        $this->commission->Description = $commission->Description;
        $this->commission->Url = $commission->Url;

        return $this->commission;
    }

    /**
     * @param \raec\models\Role $role
     *
     * @return \stdClass
     */
    public function buildUserCommission($role)
    {
        $this->user->Commission = new \stdClass();

        $this->user->Commission->RoleId = $role->Id;
        $this->user->Commission->RoleName = $role->Title; //todo: deprecated
        $this->user->Commission->RoleTitle = $role->Title;

        return $this->user;
    }

    /**
     * @param \raec\models\Commission $comission
     *
     * @return \stdClass
     */
    public function buildComissionProjects($comission)
    {
        $this->commission->Projects = [];
        foreach ($comission->Projects as $pr) {
            if ($pr->Visible) {
                $project = new \stdClass();
                $project->Title = $pr->Title;
                $project->Description = $pr->Description;
                $project->Users = [];
                foreach ($pr->Users as $prUser) {
                    $project->Users[] = $prUser->User->RunetId;
                }
                $this->commission->Projects[] = $project;
            }
        }

        return $this->commission;
    }

    protected $section;

    /**
     * @param \event\models\section\Section $section
     * @return \stdClass
     */
    public function createSection($section)
    {
        $this->applyLocale($section);

        $this->section = new \stdClass();

        $this->section->SectionId = $section->Id;
        $this->section->Id = $section->Id;
        $this->section->Title = $this->filterSectionTitle($section->Title);
        $this->section->ShortTitle = $section->ShortTitle;
        $this->section->Description = $section->Info; //todo: deprecated
        $this->section->Info = $section->Info;
        $this->section->Start = $section->StartTime;
        $this->section->Finish = $section->EndTime; //todo: deprecated
        $this->section->End = $section->EndTime;
        $this->section->UpdateTime = $section->UpdateTime;
        $this->section->Deleted = $section->Deleted;
        $this->section->Type = $section->TypeId == 4 ? 'short' : 'full'; //todo: deprecated
        $this->section->TypeCode = $section->Type->Code;

        if (sizeof($section->LinkHalls) > 0) {
            $this->section->Place = $section->LinkHalls[0]->Hall->Title; //todo: deprecated
        }
        $this->section->Halls = [];
        $this->section->Places = [];
        foreach ($section->LinkHalls as $linkHall) {
            $this->section->Places[] = $linkHall->Hall->Title;
            $this->section->Halls[] = $this->createSectionHall($linkHall->Hall);
        }

        $this->section->Attributes = [];
        foreach ($section->Attributes as $attribute) {
            $this->section->{$attribute->Name} = $attribute->Value; //todo: deprecated
            $this->section->Attributes[$attribute->Name] = $attribute->Value;
        }

        $this->section->Speakers = [];
        foreach ($section->LinkUsers as $linkUser) {
            $this->section->Speakers[] = $linkUser->User->RunetId;
        }

        return $this->section;
    }

    protected $sectionHall;

    /**
     * @param Hall $hall
     * @return \stdClass
     */
    public function createSectionHall($hall)
    {
        $this->applyLocale($hall);

        $this->sectionHall = new \stdClass();
        $this->sectionHall->Id = $hall->Id;
        $this->sectionHall->Title = $hall->Title;
        $this->sectionHall->UpdateTime = $hall->UpdateTime;
        $this->sectionHall->Order = $hall->Order;
        $this->sectionHall->Deleted = $hall->Deleted;

        return $this->sectionHall;
    }

    protected function filterSectionTitle($title)
    {
        if ($this->account->Role === Account::ROLE_MOBILE) {
            return (new \application\components\utility\Texts())->filterPurify($title);
        }

        return $title;
    }

    protected $report;

    /**
     * @param \event\models\section\LinkUser $link
     * @return \stdClass
     */
    public function createReport($link)
    {
        $this->report = new \stdClass();

        $this->report->Id = $link->Id;
        if (!empty($link->User)) {
            $this->report->User = $this->createUser($link->User, [
                self::USER_PERSON,
                self::USER_PHOTO,
                self::USER_ATTRIBUTES,
                self::USER_EMPLOYMENT
            ]);
        } elseif (!empty($link->Company)) {
            $this->report->Company = $this->createCompany($link->Company);
        } else {
            $this->report->CustomText = $link->CustomText;
        }

        $this->report->SectionRoleId = $link->Role->Id;
        $this->report->SectionRoleName = $link->Role->Title;//todo: deprecated
        $this->report->SectionRoleTitle = $link->Role->Title;
        $this->report->Order = $link->Order;
        if (!empty($link->Report)) {
            $this->report->Header = $link->Report->Title;//todo: deprecated
            $this->report->Title = $link->Report->Title;
            $this->report->Thesis = $link->Report->Thesis;
            $this->report->FullInfo = $link->Report->FullInfo;
            $this->report->LinkPresentation = $link->Report->Url;//todo: deprecated
            $this->report->Url = $link->Report->Url;
        }
        $this->report->VideoUrl = $link->VideoUrl;
        $this->report->UpdateTime = $link->UpdateTime;
        $this->report->Deleted = $link->Deleted;

        return $this->report;
    }

    protected $favorite;

    /**
     * @param Favorite $favorite
     * @return \stdClass
     */
    public function createFavorite($favorite)
    {
        $this->favorite = new \stdClass();
        $this->favorite->SectionId = $favorite->SectionId;
        $this->favorite->Deleted = $favorite->Deleted;
        $this->favorite->UpdateTime = $favorite->UpdateTime;

        return $this->favorite;
    }

    protected $inviteRequest;

    /**
     * @param \event\models\InviteRequest $request
     * @return \stdClass
     */
    public function createInviteRequest(\event\models\InviteRequest $request)
    {
        $this->inviteRequest = new \stdClass();
        $this->inviteRequest->Sender = $this->createBaseUser($request->Sender);
        $this->inviteRequest->Owner = $this->createBaseUser($request->Owner);
        $this->inviteRequest->CreationTime = $request->CreationTime;
        $this->inviteRequest->Event = $this->createEvent($request->Event);
        $this->inviteRequest->Approved = $request->Approved;

        return $this->inviteRequest;
    }

    protected $purpose;

    /**
     * @param \event\models\Purpose $purpose
     */
    public function createEventPuprose(\event\models\Purpose $purpose)
    {
        $this->purpose = new \stdClass();
        $this->purpose->Id = $purpose->Id;
        $this->purpose->Title = $purpose->Title;

        return $this->purpose;
    }

    protected $professionalInterest;

    /**
     * @param \application\models\ProfessionalInterest $professionalInterest
     * @return \stdClass
     */
    public function createProfessionalInterest(\application\models\ProfessionalInterest $professionalInterest)
    {
        $this->professionalInterest = new \stdClass();
        $this->professionalInterest->Id = $professionalInterest->Id;
        $this->professionalInterest->Title = $professionalInterest->Title;

        return $this->professionalInterest;
    }

    protected $userDocumentType;

    /**
     * @param DocumentType $documentType
     * @return \stdClass
     */
    public function createUserDocumentType(DocumentType $documentType)
    {
        $this->userDocumentType = new \stdClass();
        $this->userDocumentType->Id = $documentType->Id;
        $this->userDocumentType->Title = $documentType->Title;

        return $this->userDocumentType;
    }

    protected $userDocument;

    /**
     * @param Document $document
     * @return \stdClass
     */
    public function buildUserDocument(Document $document)
    {
        $this->user->Document = new \stdClass();
        $this->user->Document->Type = $this->createUserDocumentType($document->Type);
        $this->user->Document->Fields = $document->Attributes;

        return $this->user->Document;
    }

    /**
     * @param Test $test
     * @return \stdClass
     */
    public function buildCompetenceTest(Test $test)
    {
        $builtTest = new \stdClass();

        $builtTest->Id = $test->Id;
        $builtTest->Title = $test->Title;
        $builtTest->Questions = [];

        $questions = Question::model()->byTestId($test->Id)->findAll();

        foreach ($questions as $question) {
            $builtQuestion = new \stdClass();

            $builtQuestion->Title = $question->Title;

            $data = $question->getFormData();

            if (isset($data['Values'])) {
                $builtQuestion->Values = [];

                foreach ($data['Values'] as $value) {
                    $builtQuestion->Values[$value->key] = $value->title;
                }
            }

            $builtTest->Questions[$question->Code] = $builtQuestion;
        }

        return $builtTest;
    }

    /**
     * @param Result $result
     * @return \stdClass
     */
    public function buildCompetenceResult(Result $result)
    {
        $builtResult = new \stdClass();
        $data = $result->getResultByData();

        foreach ($data as $key => $item) {
            $builtItem = new \stdClass();

            $builtItem->Value = $item['value'];

            if (isset($item['other'])) {
                $builtItem->Other = $item['other'];
            }

            $builtResult->$key = $builtItem;
        }

        return $builtResult;
    }

    /**
     * Применяет локаль к модели, если она это поддерживает
     * (т.е. наследует класс application\models\translation\ActiveRecord)
     *
     * @param \CActiveRecord $activeRecord
     */
    protected function applyLocale(\CActiveRecord $activeRecord)
    {
        if ($activeRecord instanceof ActiveRecord) {
            $activeRecord->setLocale(Yii::app()->getLanguage());
        }
    }

    /**
     * Проверяет, имеет ли указанный пользователь доступ к контактным данным
     *
     * @param User $user
     * @return bool
     */
    protected function hasPrivatePermission(User $user)
    {
        static $permissions;

        if ($permissions === null) {
            $permissions = [];
        }

        if (isset($permissions[$user->RunetId]) === false) {
            switch ($this->account->Role) {
                case Account::ROLE_OWN:
                    $permissions[$user->RunetId] = true;
                    break;

                case Account::ROLE_PARTNER_WOC:
                    $permissions[$user->RunetId] = $this->account->Event->hasParticipant($user);
                    break;

                case Account::ROLE_MOBILE:
                    $permissions[$user->RunetId] = true;
                    break;

                case Account::ROLE_PROFIT:
                    $permissions[$user->RunetId] = false;
                    break;

                default:
                    $permissions[$user->RunetId] = $this->account->Event->hasParticipant($user)
                        || Permission::model()
                            ->byUserId($user->Id)
                            ->byAccountId($this->account->Id)
                            ->byDeleted(false)
                            ->exists();
            }
        }

        return $permissions[$user->RunetId];
    }

    protected $meetingPlace;

    public function createMeetingPlace($place)
    {
        $this->meetingPlace = new \stdClass();

        $this->meetingPlace->Id = $place->Id;
        $this->meetingPlace->Name = $place->Name;
        $this->meetingPlace->Reservation = $place->Reservation ? 'true' : 'false';
        $this->meetingPlace->ReservationTime = $place->ReservationTime;

        return $this->meetingPlace;
    }

    protected $meeting;

    /**
     * @param $meeting Meeting
     * @return \stdClass
     */
    public function createMeeting($meeting)
    {
        $this->meeting = new \stdClass();

        $this->meeting->Id = $meeting->Id;
        $this->meeting->Place = $this->createMeetingPlace($meeting->Place);
        $this->meeting->Creator = $this->createUser($meeting->Creator);
        $this->meeting->Users = array_map(function ($link) {
            $user = new \stdClass();
            $user->Status = $link->Status;
            $user->Response = $link->Response;
            $user->User = $this->createUser($link->User);

            return $user;
        }, $meeting->UserLinks);
        $this->meeting->UserCount = count($meeting->UserLinks);
        $this->meeting->Start = $meeting->Date;
        # TODO: deprecated
        $this->meeting->Date = substr($meeting->Date, 0, 10);
        # TODO: deprecated
        $this->meeting->Time = substr($meeting->Date, 11, 5);
        $this->meeting->Type = $meeting->Type;
        $this->meeting->Purpose = $meeting->Purpose;
        $this->meeting->Subject = $meeting->Subject;
        $this->meeting->File = $meeting->getFileUrl();
        $this->meeting->CreateTime = $meeting->CreateTime;
        $this->meeting->Status = $meeting->Status;
        $this->meeting->CancelResponse = $meeting->CancelResponse;

        return $this->meeting;
    }

    /**
     * Формирует данные об участии в секциях мероприятия
     *
     * @param User $user
     * @return array
     */
    public function createUserSections($user)
    {
        $result = [];
        foreach ($this->account->Event->Sections as $section) {
            foreach ($user->LinkSections as $link) {
                /** @var LinkUser $link */
                if ($link->Section->Id == $section->Id) {
                    $data = new \stdClass();
                    $data->Section = $this->createSection($section);
                    $data->Role = $link->Role->Title;
                    $data->VideoUrl = $link->VideoUrl;
                    if ($link->Report) {
                        $report = new \stdClass();
                        $report->Id = $link->Report->Id;
                        $report->Title = $link->Report->Title;
                        $report->Thesis = $link->Report->Thesis;
                        $report->FullInfo = $link->Report->FullInfo;
                        $report->Url = $link->Report->Url;
                        $data->Report = $report;
                    }
                    $result[] = $data;
                }
            }
        }

        return $result;
    }

    protected $paperlessMaterial;

    /**
     * @param Material $material
     * @return mixed
     */
    public function createPaperlessMaterial($material)
    {
        $this->paperlessMaterial = (object)[
            'Id' => $material->Id,
            'Name' => $material->Name,
            'File' => $material->getFileUrl(true),
            'Comment' => $material->Comment,
            'Partner' => (object)[
                'Name' => $material->PartnerName,
                'Site' => $material->PartnerSite,
                'Logo' => $material->getPartnerLogoUrl(true)
            ]
        ];

        return $this->paperlessMaterial;
    }
}
