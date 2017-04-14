<?php
namespace api\components\builders;

use api\models\Account;
use api\models\AccoutQuotaByUserLog;
use api\models\ExternalUser;
use application\components\helpers\ArrayHelper;
use application\components\utility\Texts;
use application\models\translation\ActiveRecord;
use company\models\Company;
use competence\models\Question;
use competence\models\Result;
use competence\models\Test;
use connect\models\Meeting;
use event\models\Event;
use event\models\section\Favorite;
use event\models\section\Hall;
use event\models\section\LinkUser;
use event\models\UserData;
use oauth\models\Permission;
use paperless\models\Material;
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
    const USER_EMPLOYMENT = 'buildUserEmployment';
    const USER_EVENT = 'buildUserEvent';
    const USER_DATA = 'buildUserData';
    const USER_BADGE = 'buildUserBadge';
    const USER_CONTACTS = 'buildUserContacts';
    const USER_ATTRIBUTES = 'buildUserAttributes';
    const USER_EXTERNALID = 'buildUserExternalId';
    const USER_AUTH = 'buildAuthData';

    /**
     * Построение схемы данных посетителя
     *
     * @param User|\commission\models\User $user
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
                self::USER_DATA,
                self::USER_ATTRIBUTES,
                self::USER_EMPLOYMENT,
                self::USER_EVENT,
                self::USER_BADGE,
                self::USER_CONTACTS,
                self::USER_EXTERNALID
            ];
        }

        // Строим модель данных посетителя только из указанных блоков
        foreach ($builders as $builderName) {
            $this->$builderName($user);
        }

        return $this->user;
    }

    /**
     * @param \user\models\User|\commission\models\User $user
     * @return \stdClass
     */
    protected function createBaseUser($user)
    {
        $this->applyLocale($user);

        $this->user = new \stdClass();

        $this->user->RocId = $user->RunetId; //todo: deprecated
        $this->user->RunetId = $user->RunetId;
        $this->user->LastName = $user->LastName;
        $this->user->FirstName = $user->FirstName;
        $this->user->FatherName = $user->FatherName;

        if ($this->hasPrivatePermission($user)) {
            $this->user->CreationTime = $user->CreationTime;
            $this->user->Visible = $user->Visible;
            $this->user->Verified = $user->Verified;
            $this->user->Gender = $user->Gender;
        }

        $this->user->Photo = new \stdClass();
        $this->user->Photo->Small = SCHEMA.'://'.RUNETID_HOST.$user->getPhoto()->get50px();;
        $this->user->Photo->Medium = SCHEMA.'://'.RUNETID_HOST.$user->getPhoto()->get90px();
        $this->user->Photo->Large = SCHEMA.'://'.RUNETID_HOST.$user->getPhoto()->get200px();

        return $this->user;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection
     * @return \stdClass
     */
    protected function buildAuthData()
    {
        $this->user->AuthCode = Texts::GenerateString(10);

        return $this->user;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection
     * @param \user\models\User|\commission\models\User $user
     * @return \stdClass
     */
    protected function buildUserData($user)
    {
        if ($this->hasPrivatePermission($user)) {
            $attributes = UserData::getDefinedAttributeValues($this->account->Event, $user);

            if (!empty($attributes)) {
                $this->user->Attributes = $attributes;
            }
        }

        return $this->user;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection
     * @param \user\models\User|\commission\models\User $user
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

    /** @noinspection PhpUnusedPrivateMethodInspection
     * @param \user\models\User|\commission\models\User $user
     * @return \stdClass
     */
    protected function buildUserEvent($user)
    {
        $isOnePart = empty($this->account->Event->Parts);
        foreach ($user->Participants as $participant) {
            // Для оффлайн сервисов добавляем в выдачу идентификатор RFID-бейджа
            if ($this->account->Role === Account::ROLE_OFFLINE && empty($participant->BadgeId) !== true) {
                $this->user->BadgeId = $participant->BadgeId;
            }
            if ($participant->EventId == $this->account->EventId) {
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
     * @param \user\models\User|\commission\models\User $user
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
     * @param User|\commission\models\User $user
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

    /**
     * @noinspection PhpUnusedPrivateMethodInspection
     * @param User|\commission\models\User $user
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
            'Name' => $company->Name,
            'FullName' => $company->FullName,
            'Info' => $company->Info,
            'Logo' => [
                'Small' => 'http://'.RUNETID_HOST.$company->getLogo()->get50px(),
                'Medium' => 'http://'.RUNETID_HOST.$company->getLogo()->get90px(),
                'Large' => 'http://'.RUNETID_HOST.$company->getLogo()->get200px(),
            ],
            'Url' => (string)$company->getContactSite(),
            'Phone' => !empty($company->LinkPhones[0]) ? (string)$company->LinkPhones[0]->Phone : null,
            'Email' => null,
            'Address' => (string)$company->getContactAddress()
        ];

        if (null !== ($email = $company->getContactEmail())) {
            $this->company->Email = $email->Email;
        }

        if ($this->account->Role === Account::ROLE_OWN) {
            $this->company->Cluster = $company->Cluster;
            $this->company->ClusterGroups = ArrayHelper::columnGet('Id', $company->RaecClusters);
            $this->company->OGRN = $company->OGRN;
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

        $this->event = new \stdClass();

        $this->event->EventId = $event->Id;
        $this->event->IdName = $event->IdName;
        $this->event->Name = html_entity_decode($event->Title); //todo: deprecated
        $this->event->Title = html_entity_decode($event->Title);
        $this->event->Info = $event->Info;
        if ($event->getContactAddress() !== null) {
            $this->event->Place = $event->getContactAddress()->__toString();
        }
        $this->event->Url = $event->getContactSite() !== null ? (string)$event->getContactSite() : '';
        $this->event->UrlRegistration = '';//$event->UrlRegistration;
        $this->event->UrlProgram = '';// $event->UrlProgram;
        $this->event->StartYear = $event->StartYear;
        $this->event->StartMonth = $event->StartMonth;
        $this->event->StartDay = $event->StartDay;
        $this->event->EndYear = $event->EndYear;
        $this->event->EndMonth = $event->EndMonth;
        $this->event->EndDay = $event->EndDay;

        $this->event->Image = new \stdClass();

        $webRoot = Yii::getPathOfAlias('webroot');
        $logo = $event->getLogo();
        $this->event->Image->Mini = 'http://'.RUNETID_HOST.$logo->getMini();
        $this->event->Image->MiniSize = $this->getImageSize($webRoot.$logo->getMini());
        $this->event->Image->Normal = 'http://'.RUNETID_HOST.$logo->getNormal();
        $this->event->Image->NormalSize = $this->getImageSize($webRoot.$logo->getNormal());

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
        $this->createBaseUser($orderItem->Payer);
        $this->orderItem->Payer = $this->buildUserEmployment($orderItem->Payer);

        $owner = $orderItem->ChangedOwner !== null ? $orderItem->ChangedOwner : $orderItem->Owner;
        $this->createBaseUser($owner);
        $this->orderItem->Owner = $this->buildUserEmployment($owner);

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
     * @param \commission\models\Commission $commission
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
     * @param \commission\models\Role $role
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
     * @param \commission\models\Commission $comission
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

                case Account::ROLE_MOBILE: // toDo: Не совсем понятна причина такого, но текущая версия api именно так и выбирала данные в списках посетителей, потом я это добавил сюда
                    $permissions[$user->RunetId] = false;
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
