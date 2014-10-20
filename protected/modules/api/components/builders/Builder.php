<?php
namespace api\components\builders;
use event\models\section\Favorite;
use event\models\section\Hall;

/**
 * Методы делятся на 2 типа:
 * 1. Методы вида createXXX - создают объект с основными данными XXX, сбрасывают предыдущее заполнение объекта XXX
 * 2. Методы вида buildXXXSomething - дополняют созданный объект XXX новыми данными. Какими именно, можно понять по названию Something
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
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function createUser(\user\models\User $user)
    {
        $this->user = new \stdClass();

        $this->user->RocId = $user->RunetId; //todo: deprecated
        $this->user->RunetId = $user->RunetId;
        $this->user->LastName = $user->LastName;
        $this->user->FirstName = $user->FirstName;
        $this->user->FatherName = $user->FatherName;
        $this->user->CreationTime = $user->CreationTime;

        $this->user->Photo = new \stdClass();
        $this->user->Photo->Small  = 'http://' . RUNETID_HOST . $user->getPhoto()->get50px();;
        $this->user->Photo->Medium = 'http://' . RUNETID_HOST . $user->getPhoto()->get90px();
        $this->user->Photo->Large  = 'http://' . RUNETID_HOST . $user->getPhoto()->get200px();

        return $this->user;
    }

    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function buildUserContacts(\user\models\User $user)
    {
        $this->user->Email = $user->Email;
        $this->user->Phones = array();
        foreach ($user->LinkPhones as $link)
        {
            $this->user->Phones[] = (string) $link->Phone;
        }
        return $this->user;
    }

    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function buildUserEmployment($user)
    {
        $employment = $user->getEmploymentPrimary();
        if ($employment !== null)
        {
            $this->user->Work = new \stdClass();
            $this->user->Work->Position = $employment->Position;
            $this->user->Work->Company = $this->createCompany($employment->Company);
            $this->user->Work->StartYear = $employment->StartYear;
            $this->user->Work->StartMonth = $employment->StartMonth;
            $this->user->Work->EndYear = $employment->EndYear;
            $this->user->Work->EndMonth = $employment->EndMonth;
        }

        return $this->user;
    }

    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function buildUserEvent(\user\models\User $user)
    {
        $isOnePart = $this->account->EventId != null && empty($this->account->Event->Parts);
        foreach ($user->Participants as $participant)
        {
            if ($this->account->EventId != null && $participant->EventId == $this->account->EventId)
            {
                if ($isOnePart)
                {
                    $this->user->Status = new \stdClass();
                    $this->user->Status->RoleId = $participant->RoleId;
                    $this->user->Status->RoleName = $participant->Role->Title;
                    $this->user->Status->RoleTitle = $participant->Role->Title;
                    $this->user->Status->UpdateTime = $participant->UpdateTime;
                    $this->user->Status->TicketUrl = $participant->getTicketUrl();
                }
                else
                {
                    if (!isset($this->user->Status))
                    {
                        $this->user->Status = array();
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
            elseif ($this->account->EventId == null)
            {
                if (!$participant->Event->Visible)
                {
                    continue;
                }
                $status = new \stdClass();
                $status->RoleId = $participant->RoleId;
                $status->RoleName = $participant->Role->Title;
                $status->RoleTitle = $participant->Role->Title;
                $status->UpdateTime = $participant->UpdateTime;
                $status->Event = $this->CreateEvent($participant->Event);
                $this->user->Status[] = $status;
            }
        }

        return $this->user;
    }

    public function buildUserBadge(\user\models\User $user)
    {
        $isOnePart = $this->account->EventId != null && empty($this->account->Event->Parts);
        if ($isOnePart && !empty($this->user->Status))
        {
            $model =  \ruvents\models\Badge::model()
                ->byEventId($this->account->EventId)->byUserId($user->Id);
            $this->user->Status->Registered = $model->exists();
        }

        return $this->user;
    }

    protected $company;
    /**
     * @param \company\models\Company $company
     * @return \stdClass
     */
    public function createCompany(\company\models\Company $company)
    {
        $this->company = new \stdClass();
        $this->company->CompanyId = $company->Id;
        $this->company->Name = $company->Name;

        return $this->company;
    }

    protected $role;
    /**
     * @param \event\models\Role $role
     * @return \stdClass
     */
    public function createRole(\event\models\Role $role)
    {
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
        $this->event = new \stdClass();

        $this->event->EventId = $event->Id;
        $this->event->IdName = $event->IdName;
        $this->event->Name = html_entity_decode($event->Title); //todo: deprecated
        $this->event->Title = html_entity_decode($event->Title);
        $this->event->Info = $event->Info;
        if ($event->getContactAddress() !== null)
        {
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

        $webRoot = \Yii::getPathOfAlias('webroot');
        $logo = $event->getLogo();
        $this->event->Image->Mini = 'http://'. RUNETID_HOST . $logo->getMini();
        $this->event->Image->MiniSize = $this->getImageSize($webRoot . $logo->getMini());
        $this->event->Image->Normal = 'http://'. RUNETID_HOST . $logo->getNormal();
        $this->event->Image->NormalSize = $this->getImageSize($webRoot . $logo->getNormal());

        return $this->event;
    }

    private function getImageSize($path)
    {
        $size = null;
        if (file_exists($path))
        {
            $key = md5($path);
            $size = \Yii::app()->getCache()->get($key);
            if ($size === false)
            {
                $size = new \stdClass();
                $image = imagecreatefrompng($path);
                $size->Width = imagesx($image);
                $size->Height = imagesy($image);
                imagedestroy($image);
                \Yii::app()->getCache()->add($key, $size, 3600 + mt_rand(10, 500));
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
        if ($address !== null)
        {
            $this->event->GeoPoint = $address->GeoPoint;
            $this->event->Address = $address->__toString();
        }
        if (!empty($event->FbPlaceId))
        {
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
        $this->event->Menu = array();

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


    protected $product;
    /**
     * @param \pay\models\Product $product
     * @param string $time
     * @return \stdClass
     */
    public function createProduct($product, $time = null)
    {
        $this->product = new \stdClass();
        $this->product->Id = $product->Id;
        $this->product->ProductId = $product->Id; /** todo: deprecated **/
        $this->product->Manager = $product->ManagerName;
        $this->product->Title = $product->Title;
        $this->product->Price = $product->getPrice($time);
        $this->product->Attributes = array();
        foreach ($product->Attributes as $attribute)
        {
            $this->product->Attributes[$attribute->Name] = $attribute->Value;
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

        $this->orderItem->OrderItemId = $orderItem->Id; /** todo: deprecated **/
        $this->orderItem->Id = $orderItem->Id;
        $this->orderItem->Product = $this->CreateProduct($orderItem->Product, $orderItem->PaidTime);
        $this->createUser($orderItem->Payer);
        $this->orderItem->Payer = $this->buildUserEmployment($orderItem->Payer);

        $owner = $orderItem->ChangedOwner !== null ? $orderItem->ChangedOwner : $orderItem->Owner;
        $this->createUser($owner);
        $this->orderItem->Owner = $this->buildUserEmployment($owner);

        $this->orderItem->PriceDiscount = $item->getPriceDiscount();
        $this->orderItem->Paid = $orderItem->Paid == 1;
        $this->orderItem->PaidTime = $orderItem->PaidTime;
        $this->orderItem->Booked = $orderItem->Booked;
        $this->orderItem->Deleted = $orderItem->Deleted;
        $this->orderItem->CreationTime = $orderItem->CreationTime;

        $this->orderItem->Attributes = array();
        foreach ($orderItem->Attributes as $attribute)
        {
            $this->orderItem->Attributes[$attribute->Name] = $attribute->Value;
        }
        $this->orderItem->Params = $this->orderItem->Attributes; /** todo: deprecated */


        $this->orderItem->Discount = $item->getDiscount();
        $couponActivation = $orderItem->getCouponActivation();
        $this->orderItem->CouponCode = !empty($couponActivation) && !empty($couponActivation->Coupon) ? $couponActivation->Coupon->Code : null;
        $this->orderItem->GroupDiscount = $item->getIsGroupDiscount();
        return $this->orderItem;
    }









    protected $commission;

    /**
     * @param \commission\models\Commission $commission
     * @return \stdClass
     */
    public function createCommision ($commission)
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
        $this->commission->Projects = array();
        foreach ($comission->Projects as $pr)
        {
            if ($pr->Visible)
            {
                $project = new \stdClass();
                $project->Title = $pr->Title;
                $project->Description = $pr->Description;
                $project->Users = array();
                foreach ($pr->Users as $prUser)
                {
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
        $this->section = new \stdClass();

        $this->section->SectionId = $section->Id;
        $this->section->Id = $section->Id;
        $this->section->Title = $this->filterSectionTitle($section->Title);
        $this->section->Description = $section->Info; //todo: deprecated
        $this->section->Info = $section->Info;
        $this->section->Start = $section->StartTime;
        $this->section->Finish = $section->EndTime; //todo: deprecated
        $this->section->End = $section->EndTime;
        $this->section->UpdateTime = $section->UpdateTime;
        $this->section->Deleted = $section->Deleted;
        $this->section->Type = $section->TypeId == 4 ? 'short' : 'full'; //todo: deprecated
        $this->section->TypeCode = $section->Type->Code;

        if (sizeof($section->LinkHalls) > 0)
        {
            $this->section->Place = $section->LinkHalls[0]->Hall->Title; //todo: deprecated
        }
        $this->section->Halls  = [];
        $this->section->Places = array();
        foreach ($section->LinkHalls as $linkHall)
        {
            $this->section->Places[] = $linkHall->Hall->Title;
            $this->section->Halls[]  = $this->createSectionHall($linkHall->Hall);
        }

        $this->section->Attributes = array();
        foreach ($section->Attributes as $attribute)
        {
            $this->section->{$attribute->Name} = $attribute->Value; //todo: deprecated
            $this->section->Attributes[$attribute->Name] = $attribute->Value;
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
        if ($this->account->Role == 'mobile')
        {
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
            $this->createUser($link->User);
            $this->report->User = $this->buildUserEmployment($link->User);
        } elseif (!empty($link->Company)) {
            $this->report->Company = $this->createCompany($link->Company);
        } else {
            $this->report->CustomText = $link->CustomText;
        }

        $this->report->SectionRoleId = $link->Role->Id;
        $this->report->SectionRoleName = $link->Role->Title;//todo: deprecated
        $this->report->SectionRoleTitle = $link->Role->Title;
        $this->report->Order = $link->Order;
        if (! empty($link->Report)) {
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
        $this->inviteRequest->Sender = $this->createUser($request->Sender);
        $this->inviteRequest->Owner = $this->createUser($request->Owner);
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
}
