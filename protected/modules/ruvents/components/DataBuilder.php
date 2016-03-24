<?php
namespace ruvents\components;

use application\components\helpers\ArrayHelper;
use application\models\attribute\Definition;
use event\models\UserData;
use ruvents\models\Setting;
use user\models\User;

class DataBuilder
{
    private $eventId;
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    private $activeEvent = null;

    /**
     * @return \event\models\Event
     */
    public function getEvent()
    {
        if ($this->activeEvent == null)
            $this->activeEvent = \event\models\Event::model()->findByPk($this->eventId);

        return $this->activeEvent;
    }

    protected $operator;

    /**
     * @param \ruvents\models\Operator $operator
     * @return \stdClass
     */
    public function createOperator($operator)
    {
        $this->operator = new \stdClass();

        $this->operator->Id = $operator->Id;
        $this->operator->Login = $operator->Login;
        $this->operator->Password = $operator->Password;
        $this->operator->Role = $operator->Role;

        return $this->operator;
    }

    protected $user;
    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function createUser($user)
    {
        $photoPath =
        $this->user = (object) [
            'RunetId' => $user->RunetId,
            'LastName' => $user->LastName,
            'FirstName' => $user->FirstName,
            'FatherName' => $user->FatherName,
            'Birthday' => $user->Birthday,
            'UpdateTime' => $user->UpdateTime,
            'Gender' => $user->Gender,
            'CreationTime' => $user->CreationTime,
            'Email' => trim($user->Email),
            'Locales' => $this->getLocales($user),
            'Photo' => (object) [
                'Small' => $user->getPhoto()->get50px(),
                'Medium' => $user->getPhoto()->get90px(),
                'Large' => $user->getPhoto()->get200px(),
                'Original' => str_replace('/files/photo/', 'http://static.runet-id.com/photo/', $user->getPhoto()->getOriginal())
            ],
        ];

        return $this->user;
    }

    /**
     *
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function buildUserPhone ($user)
    {
        if ($user->PrimaryPhone !== null) {
            $this->user->Phone = $user->PrimaryPhone;
        } else {
            $phone = $user->getContactPhone(\contact\models\PhoneType::Mobile);
            if ($phone !== null) {
                $this->user->Phone = (string)$phone;
            }
        }
        return $this->user;
    }


    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function buildUserEmployment($user)
    {
        foreach ($user->Employments as $employment)
        {
            if ($employment->Primary == 1 && !empty($employment->Company))
            {
                $this->user->Work = new \stdClass();
                $this->user->Work->Position = $employment->Position;
                $this->user->Work->Company = $this->CreateCompany($employment->Company);
                $this->user->Work->StartYear = $employment->StartYear;
                $this->user->Work->StartMonth = $employment->StartMonth;
                $this->user->Work->EndYear = $employment->EndYear;
                $this->user->Work->EndMonth = $employment->EndMonth;
                return $this->user;
            }
        }

        return $this->user;
    }

    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function buildUserEvent($user)
    {
        $this->user->Statuses = [];

        foreach ($user->Participants as $participant)
            if ($participant->EventId == $this->eventId)
                $this->user->Statuses[$participant->PartId ? $participant->PartId : 0] = $participant->RoleId;

        /**
         * Данное преобразование важно для корректной передачи роли безпартийного мероприятия
         * виде ассоциативного масива с индексом 0. То есть "Statuses":{"0":1}
         */
        $this->user->Statuses = (object) $this->user->Statuses;

        return $this->user;
    }

    /**
     * @param User $user
     * @return \stdClass
     */
    public function buildUserData($user)
    {
        $settings = $this->getEvent()->RuventsSettings;

        $attributes = array_merge(
            $settings->EditableUserData ?: [],
            $settings->AvailableUserData ?: []
        );

        $data = $this->getEvent()->getUserData($user);

        if (count($data) > 0) {
            $this->user->Attributes = [];
            $this->user->Data = [];
            /** @var UserData $row */
            $row = array_pop($data);
            foreach ($row->getManager()->getDefinitions() as $definition) {
                if (in_array($definition->name, $attributes)) {
                    $value = $definition->getExportValue($row->getManager());
                    $this->user->Attributes[$definition->name] = $value;
                    $this->user->Data[$definition->title] = $value;
                }
            }
        }

        return $this->user;
    }

    protected $company;
    /**
     * @param \company\models\Company $company
     * @return \stdClass
     */
    public function createCompany($company)
    {
        $this->company = new \stdClass();

        $this->company->CompanyId = $company->Id;
        $this->company->Name = $company->Name;
        $this->company->Locales = $this->getLocales($company);
        return $this->company;
    }

    protected $event;

    public function createEvent()
    {
        $event = $this->getEvent();

        /* Базовые данные о мероприятии */
        $this->event = (object) [
            'EventId' => $event->Id,
            'IdName' => $event->IdName,
            'Title' => $event->Title,
            'Info' => $event->Info,
            'Parts' => [],
            'Roles' => []
        ];

        /* Доступные части */
        foreach ($event->Parts as $part) {
            $this->event->Parts[] = (object) [
                'PartId' => $part->Id,
                'Title' => $part->Title,
                'Order' => $part->Order
            ];
        }

        /* Доступные статусы участия */
        foreach ($event->getRoles() as $role)
            $this->event->Roles[] = $this->createRole($role);

        /* Настройки мероприятия, используемые в качестве
         * настроек клиента */
        $this->buildEventSettings();

        return $this->event;
    }

    private function buildEventSettings()
    {
        $event = $this->getEvent();
        $settings = $event->RuventsSettings;

        $definitions = Definition::model()
            ->byModelId($event->Id)
            ->byModelName('EventUserData')
            ->orderBy('"t"."Order"')
            ->findAllByAttributes([
                'Name' => array_merge(
                    $settings->EditableUserData ?: [],
                    $settings->AvailableUserData ?: []
                )
            ]);

        if (count($definitions) === 0)
            return;

        $this->event->Settings = new \stdClass();
        $this->event->Settings->PersonAttributes = new \stdClass();

        foreach ($definitions as $definition) {
            $this->event->Settings->PersonAttributes->{$definition->Name} = ArrayHelper::toArray(
                $definition, [
                    'application\models\attribute\Definition' => [
                        'Type' => 'ClassName',
                        'Title',
                        'Variants' => function (Definition $model) {
                            $params = $model->getParams();
                            return isset($params['data'])
                                ? $params['data']
                                : [];
                        },
                        'Editable' => function (Definition $model) use ($settings) {
                            return isset($settings->EditableUserData) && in_array($model->Name, $settings->EditableUserData);
                        }
                    ]
                ]
            );
        }
    }


    protected $badge;

    /**
     * @param \ruvents\models\Badge $badge
     * @return \stdClass
     */
    public function createBadge($badge)
    {
        return (object) [
            'RunetId' => $badge->User->RunetId,
            'RoleId' => $badge->RoleId,
            'RoleName' => $badge->Role->Title,
            'PartId' => $badge->PartId,
            'OperatorId' => $badge->OperatorId,
            'CreationTime' => $badge->CreationTime
        ];
    }

    protected $role;

    /**
     * @param \event\models\Role $role
     *
     * @return \stdClass
     */
    public function createRole($role)
    {
        return (object) [
            'RoleId' => $role->Id,
            'Name' => $role->Title,
            'Color' => $role->Color
        ];
    }

    protected $part;

    /**
     * @param \event\models\Part $part
     *
     * @return \stdClass
     */
    public function createPart($part)
    {
        $this->part = new \stdClass();
        $this->part->RoleId = $part->Id;
        $this->part->Name = $part->Title;
        $this->part->Order = $part->Order;

        return $this->part;
    }

    protected $orderItem;
    /**
     * @param \pay\models\OrderItem $orderItem
     * @return \stdClass
     */
    public function createOrderItem($orderItem)
    {
        $this->orderItem = new \stdClass();

        $this->orderItem->OrderItemId = $orderItem->Id;
        $this->orderItem->Product = $this->createProduct($orderItem->Product, $orderItem->PaidTime);
        $this->orderItem->PriceDiscount = $orderItem->getPriceDiscount();
        $this->orderItem->Paid = $orderItem->Paid;
        $this->orderItem->PaidTime = $orderItem->PaidTime;
        $this->orderItem->Booked = $orderItem->Booked;

        $couponActivation = $orderItem->getCouponActivation();

        if ($couponActivation !== null)
        {
            $this->orderItem->Discount = $couponActivation->Coupon->Discount;
            $this->orderItem->PromoCode = $couponActivation->Coupon->Code;
        }
        else
        {
            $this->orderItem->Discount = 0;
            $this->orderItem->PromoCode = '';
        }

        if ($this->orderItem->Discount == 1)
        {
            $this->orderItem->PayType = 'promo';
        }
        else
        {
            $this->orderItem->PayType = 'individual';
            foreach ($orderItem->OrderLinks as $link)
            {
                if ($link->Order->Type == \pay\models\OrderType::Juridical && $link->Order->Paid)
                {
                    $this->orderItem->PayType = 'juridical';
                }
            }
        }

        return $this->orderItem;
    }

    /**
     * @param \pay\models\OrderItem $orderItem
     * @return \stdClass
     */
    public function buildOrderItemOwners($orderItem)
    {
        $this->orderItem->Owner = $this->createUser($orderItem->Owner);
        $this->orderItem->ChangedOwner = !empty($orderItem->ChangedOwner) ? $this->createUser($orderItem->ChangedOwner) : null;

        return $this->orderItem;
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

        $this->product->ProductId = $product->Id;
        $this->product->Manager = $product->ManagerName;
        $this->product->Title = $product->Title;
        $this->product->Price = $product->getPrice($time);

        return $this->product;
    }

    protected $detailLog;

    /**
     * @param \ruvents\models\DetailLog $detailLog
     * @return \stdClass
     */
    public function createDetailLog($detailLog)
    {
        $this->detailLog = new \stdClass();
        $this->detailLog->OperatorId = $detailLog->OperatorId;
        $this->detailLog->OperatorLogin = $detailLog->Operator->Login;
        $this->detailLog->Changes = json_encode($detailLog->getChangeMessages());
        $this->detailLog->Time = $detailLog->CreationTime;

        return $this->detailLog;
    }

    /**
     * @param \application\models\translation\ActiveRecord $model
     * @return \stdClass
     */
    protected function getLocales($model)
    {
        $locales = new \stdClass();
        foreach (\Yii::app()->params['Languages'] as $lang)
        {
            $model->setLocale($lang);
            $localeStd = new \stdClass();
            foreach ($model->getTranslationFields() as $key)
            {
                $localeStd->{$key} = $model->{$key};
            }
            $locales->{$lang} = $localeStd;
        }
        $model->resetLocale();
        return $locales;
    }

    protected $sectionHall;

    /**
     * @param \event\models\section\Hall $hall
     * @return mixed
     */
    public function createSectionHall(\event\models\section\Hall $hall)
    {
        $this->sectionHall = new \stdClass();
        $this->sectionHall->HallId = $hall->Id;
        $this->sectionHall->Title = $hall->Title;
        return $this->sectionHall;
    }
}