<?php
namespace api\components\builders;

class BaseDataBuilder
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
    public function CreateUser($user)
    {
        $this->user = new \stdClass();

        $this->user->RunetId = $user->RunetId;
        $this->user->LastName = $user->LastName;
        $this->user->FirstName = $user->FirstName;
        $this->user->FatherName = $user->FatherName;

        $this->user->Photo = new \stdClass();
        $photo = $user->getPhoto();
        $this->user->Photo->Small = $photo->get50px();
        $this->user->Photo->Medium = $photo->get90px();
        $this->user->Photo->Large = $photo->get200px();

        return $this->user;
    }

    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function BuildUserEmail($user)
    {
        return $this->user;
    }

    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function BuildUserEmployment($user)
    {
        foreach ($user->Employments as $employment) {
            if ($employment->Primary == 1 && !empty($employment->Company)) {
                $this->user->Work = new \stdClass();
                $this->user->Work->Position = $employment->Position;
                $this->user->Work->Company = $this->CreateCompany($employment->Company);
                $this->user->Work->Start = $employment->StartWorking;
                $this->user->Work->Finish = $employment->FinishWorking;
                return $this->user;
            }
        }

        return $this->user;
    }

    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function BuildUserEvent($user)
    {
        $isSingleDay = empty($this->account->Event->Days);
        foreach ($user->Participants as $participant) {
            if ($participant->EventId === $this->account->EventId) {
                if ($isSingleDay) {
                    $this->user->Status = new \stdClass();
                    $this->user->Status->RoleId = $participant->RoleId;
                    $this->user->Status->RoleName = $participant->EventRole->Name;
                    $this->user->Status->UpdateTime = $participant->UpdateTime;
                    //todo: добавить поле UpdateTime, переделать эти поля в timestamp
                } else {
                    if (!isset($this->user->Status)) {
                        $this->user->Status = [];
                    }
                    $status = new \stdClass();
                    $status->DayId = $participant->DayId;
                    $status->RoleId = $participant->RoleId;
                    $status->RoleName = $participant->EventRole->Name;
                    $status->UpdateTime = $participant->UpdateTime;
                    $this->user->Status[] = $status;
                }
            }
        }

        return $this->user;
    }

    protected $event;

    /**
     * @param \event\models\Event $event
     * @return \stdClass
     */
    public function CreateEvent($event)
    {
        $this->event = new \stdClass();

        $this->event->EventId = $event->EventId;
        $this->event->IdName = $event->IdName;
        $this->event->Name = $event->Name;
        $this->event->Info = $event->Info;
        $this->event->Place = $event->Place;
        $this->event->Url = $event->Url;
        $this->event->UrlRegistration = $event->UrlRegistration;
        $this->event->UrlProgram = $event->UrlProgram;
        $this->event->DateStart = $event->DateStart;
        $this->event->DateEnd = $event->DateEnd;

        $this->event->Image = new \stdClass();
        $this->event->Image->Mini = 'http://rocid.ru'.$event->GetMiniLogo();
        $this->event->Image->Normal = 'http://rocid.ru'.$event->GetLogo();

        return $this->event;
    }

    /**
     * @param \event\models\Event $event
     * @return \stdClass
     */
    public function BuildEventMenu($event)
    {
        $this->event->Menu = [];

        $menu = new \stdClass();
        $menu->Type = 'program';
        $menu->Title = 'Программа';
        $this->event->Menu[] = $menu;

        $menu = new \stdClass();
        $menu->Type = 'link';
        $menu->Title = 'Программа+';
        $menu->Link = 'http://rocid.ru/files/test-api.htm';
        $this->event->Menu[] = $menu;

        $menu = new \stdClass();
        $menu->Type = 'html';
        $menu->Title = 'Дополнительная информация';
        $menu->Html = '<p>Это текст с дополнительной информацией о мероприятии. Тут может быть написано что угодно, но не очень много.</p><p>Если объем текста будет значительный - проще его передать как тип меню "link"</p>';
        $this->event->Menu[] = $menu;
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

    protected $company;

    /**
     * @param $company
     * @return \stdClass
     */
    public function CreateCompany($company)
    {
        $this->company = new \stdClass();

        $this->company->CompanyId = $company->CompanyId;
        $this->company->Name = $company->Name;

        return $this->company;
    }

    protected $orderItem;

    /**
     * @param \pay\models\OrderItem $orderItem
     * @return \stdClass
     */
    public function CreateOrderItem($orderItem)
    {
        $this->orderItem = new \stdClass();

        $this->orderItem->OrderItemId = $orderItem->OrderItemId;
        $this->orderItem->Product = $this->CreateProduct($orderItem->Product, $orderItem->PaidTime);
        $this->orderItem->Owner = $this->CreateUser($orderItem->Owner);
        $this->orderItem->PriceDiscount = $orderItem->PriceDiscount();
        $this->orderItem->Paid = $orderItem->Paid == 1;
        $this->orderItem->PaidTime = $orderItem->PaidTime;
        $this->orderItem->Booked = $orderItem->Booked;

        $this->orderItem->Params = [];
        foreach ($orderItem->Params as $param) {
            $this->orderItem->Params[$param->Name] = $param->Value;
        }

        $couponActivated = $orderItem->GetCouponActivated();
        $this->orderItem->Discount = !empty($couponActivated) && !empty($couponActivated->Coupon) ? $couponActivated->Coupon->Discount : 0;

        return $this->orderItem;
    }

    protected $product;

    /**
     * @param \pay\models\Product $product
     * @param string $time
     * @return \stdClass
     */
    public function CreateProduct($product, $time = null)
    {
        $this->product = new \stdClass();

        $this->product->ProductId = $product->ProductId;
        $this->product->Manager = $product->Manager;
        $this->product->Title = $product->Title;
        $this->product->Price = $product->GetPrice($time);

        $this->product->Attributes = [];
        foreach ($product->Attributes as $attribute) {
            $this->product->Attributes[$attribute->Name] = $attribute->Value;
        }

        return $this->product;
    }

    protected $section;

    /**
     * @param \event\models\Section $section
     * @return \stdClass
     */
    public function CreateSection($section)
    {
        $this->section = new \stdClass();

        $this->section->SectionId = $section->EventProgramId;
        $this->section->Type = $section->Type;
        $this->section->Abbr = $section->Abbr;
        $this->section->Title = $section->Title;
        $this->section->Comment = $section->Comment;
        $this->section->Audience = $section->Audience;
        $this->section->Rubricator = $section->Rubricator;
        $this->section->LinkPhoto = $section->LinkPhoto;
        $this->section->LinkVideo = $section->LinkVideo;
        $this->section->LinkShorthand = $section->LinkShorthand;
        $this->section->LinkAudio = $section->LinkAudio;
        $this->section->Start = $section->DatetimeStart;
        $this->section->Finish = $section->DatetimeFinish;
        $this->section->Place = $section->Place;
        $this->section->Description = $section->Description;
        $this->section->Partners = $section->Partners;
        $this->section->Fill = $section->Fill;
        $this->section->UpdateTime = $section->UpdateTime;

        return $this->section;
    }

    protected $report;

    /**
     * @param \event\models\SectionUserLink $link
     * @return \stdClass[]
     */
    public function CreateReport($link)
    {
        $this->report = new \stdClass();

        $this->CreateUser($link->User);
        $this->report->User = $this->BuildUserEmployment($link->User);

        $this->report->SectionRoleId = $link->Role->RoleId;
        $this->report->SectionRoleName = $link->Role->Name;
        $this->report->Order = $link->Order;
        if (!empty($link->Report)) {
            $this->report->Header = $link->Report->Header;
            $this->report->Thesis = $link->Report->Thesis;
            $this->report->LinkPresentation = $link->Report->LinkPresentation;
        }

        return $this->report;
    }

    protected $newsPost;

    /**
     * @param \news\models\Post $newsPost
     * @return \stdClass
     */
    public function CreateNewsPost($newsPost)
    {
        $this->newsPost = new \stdClass();

        $this->newsPost->PostId = $newsPost->NewsPostId;
        $this->newsPost->Title = $newsPost->Title;
        $this->newsPost->PostDate = date('r', strtotime($newsPost->PostDate));

        $discImage = $newsPost->GetMainTapeImage(true);
        if (file_exists($discImage)) {
            $this->newsPost->Image = new \stdClass();

            $this->newsPost->Image->Small = 'http://rocid.ru'.$newsPost->GetMainTapeImage();
            $this->newsPost->Image->Large = 'http://rocid.ru'.$newsPost->GetMainTapeImageBig();
            $this->newsPost->Image->Copyright = $newsPost->Copyright;
        }

        $this->newsPost->Quote = $newsPost->Quote;

        return $this->newsPost;
    }

    /**
     * @param \news\models\Post $newsPost
     */
    public function BuildNewsPostCategories($newsPost)
    {
        $categories = [];

        foreach ($newsPost->Categories as $category) {
            if ($category->Visible != 0) {
                $categories[] = $category->Title;
            }
        }

        $this->newsPost->Categories = $categories;

        return $this->newsPost;
    }

    /**
     * @param \news\models\Post $newsPost
     */
    public function BuildNewsPostContent($newsPost)
    {
        $this->newsPost->Content = \Texts::AutoPTag($newsPost->Content);

        return $this->newsPost;
    }

    public function CreateAllCategories()
    {
        $result = [];
        $categories = \news\models\Category::GetAll(true);
        foreach ($categories as $category) {
            $result[] = $category->Title;
        }
        return $result;
    }

    protected $role;

    /**
     * @param \event\models\Role $role
     * @return \stdClass
     */
    public function CreateRole($role)
    {
        $this->role = new \stdClass();

        $this->role->RoleId = $role->RoleId;
        $this->role->Name = $role->Name;
        $this->role->Priority = $role->Priority;

        return $this->role;
    }

    protected $commission;

    /**
     * @param Comission $commission
     */
    public function CreateCommision($commission)
    {
        $this->commission = new \stdClass();

        $this->commission->ComissionId = $commission->ComissionId;
        $this->commission->Title = $commission->Title;
        $this->commission->Description = $commission->Description;
        $this->commission->Url = $commission->Url;

        return $this->commission;
    }

    public function BuildUserCommission($userCommissionRole)
    {
        $this->user->Commission = new \stdClass();

        $this->user->Commission->RoleId = $userCommissionRole->RoleId;
        $this->user->Commission->RoleName = $userCommissionRole->Name;

        return $this->user;
    }
}