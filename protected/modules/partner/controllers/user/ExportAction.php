<?php
namespace partner\controllers\user;

use api\models\Account;
use api\models\ExternalUser;
use application\models\attribute\Definition;
use event\models\Participant;
use event\models\UserData;
use partner\components\Action;
use pay\components\OrderItemCollection;
use pay\models\OrderItem;
use pay\models\OrderType;
use ruvents\models\Badge;
use user\models\User;

class ExportAction extends Action
{
    private $csvDelimiter = ';';
    private $csvCharset = 'utf8';
    private $language = 'ru';

    private $rowIterator = 1;

    public function run()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $this->export();
        }
        $this->getController()->render('export', ['event' => $this->getEvent()]);
    }

    /**
     * Процесс выполнения экспорта участников
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    private function export()
    {
        ini_set("memory_limit", "512M");
        \Yii::import('ext.PHPExcel.PHPExcel', true);

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();

        $language = $request->getParam('language', 'ru');
        \Yii::app()->setLanguage($language);

        $title = \Yii::t('app', 'Участники') . ' ' . $this->getEvent()->IdName;

        $phpExcel = new \PHPExcel();
        $phpExcel->setActiveSheetIndex(0);
        $activeSheet = $phpExcel->getActiveSheet();
        $activeSheet->setTitle($title);
        $this->setHeaderRow($activeSheet);

        $users = User::model()->findAll($this->getCriteria());

        foreach ($users as $user) {
            $this->appendRow($activeSheet, $user);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $title . '.xlsx"');

        $phpExcelWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        $phpExcelWriter->save('php://output');

        \Yii::app()->end();
    }

    /**
     * Устанавливает заголовки для таблицы
     * @param \PHPExcel_Worksheet $sheet
     */
    private function setHeaderRow(\PHPExcel_Worksheet $sheet)
    {
        foreach (array_values($this->getRowMap()) as $i => $value) {
            $sheet->setCellValueByColumnAndRow($i, $this->rowIterator, $value);
        }
        $this->rowIterator++;
    }

    /**
     * Добавляет строку участника в таблицу
     * @param \PHPExcel_Worksheet $sheet
     * @param User $user
     */
    private function appendRow(\PHPExcel_Worksheet $sheet, User $user)
    {
        $formatter = \Yii::app()->getDateFormatter();
        $event = $this->getEvent();

        $row = $this->getBaseRow($user);

        /** @var Participant $participant */
        $participant = null;
        foreach ($user->Participants as $item) {
            if ($participant == null || $participant->Role->Priority < $item->Role->Priority) {
                $participant = $item;
            }
        }

        if ($participant !== null) {
            $row['Role'] = $participant->Role->Title;
            $row['DateRegister'] = $formatter->format('dd MMMM yyyy H:m', $participant->CreationTime);
        }

        $employment = $user->getEmploymentPrimary();
        if ($employment !== null) {
            $row['Company'] = $employment->Company->Name;
            $row['Position'] = $employment->Position;
        }

        $this->fillRowPayData($user, $row);

        $badge = Badge::model()->byEventId($event->Id)->byUserId($user->Id)->orderBy('"t"."CreationTime"')->find();
        if ($badge !== null) {
            $row['DateBadge'] = $formatter->format('dd MMMM yyyy H:m', $badge->CreationTime);
        }

        if ($this->hasExternalId()) {
            $externalUser = ExternalUser::model()->byAccountId($this->getApiAccount()->Id)->byUserId($user->Id)->find();
            if ($externalUser !== null) {
                $row['ExternalId'] = $externalUser->ExternalId;
            }
        }

        foreach ($this->getUserData($user) as $name => $value) {
            $row[$name] = implode(';', $value);
        }

        $i = 0;
        foreach ($row as $value) {
            $sheet->setCellValueByColumnAndRow($i++, $this->rowIterator, $value);
        }
        $this->rowIterator++;
    }

    /**
     * Возвращает строку таблицы заполненую базовыми значениями для пользователя
     * @param User $user
     * @return array
     */
    private function getBaseRow(User $user)
    {
        $row = array_fill_keys(array_keys($this->getRowMap()), '');
        $row['RUNET-ID'] = $user->RunetId;
        $row['FirstName'] = $user->FirstName;
        $row['LastName'] = $user->LastName;
        $row['FatherName'] = $user->FatherName;
        $row['Email'] = $user->Email;
        $row['Phone'] = $user->getPhone();
        $row['Birthday'] = $user->Birthday;
        $row['Role'] = '-';
        $row['Price'] = 0;
        return $row;
    }

    /**
     * Заполняет данные по оплате пользователя
     * @param User $user
     * @param $row
     * @throws \pay\components\MessageException
     */
    private function fillRowPayData(User $user, &$row)
    {
        $event = $this->getEvent();
        $formatter = \Yii::app()->getDateFormatter();

        $orderItems = OrderItem::model()
            ->byOwnerId($user->Id)
            ->byChangedOwnerId(null)
            ->byChangedOwnerId($user->Id, false)
            ->byEventId($event->Id)
            ->byPaid(true)
            ->with(['OrderLinks.Order', 'OrderLinks.Order.ItemLinks'])
            ->findAll();

        if (!empty($orderItems)) {
            $datePay  = [];
            $paidType = [];
            $products = [];
            foreach ($orderItems as $orderItem) {
                $price = 0;
                $order = $orderItem->getPaidOrder();
                if ($order !== null) {
                    $collections = OrderItemCollection::createByOrder($order);
                    foreach ($collections as $orderItemCollectable) {
                        if ($orderItemCollectable->getOrderItem()->Id == $orderItem->Id) {
                            $products[] = $orderItemCollectable->getOrderItem()->Product->Title;
                            $price = $orderItemCollectable->getPriceDiscount();
                            break;
                        }
                    }
                    $paidType[] = $order->Type == OrderType::Juridical ? \Yii::t('app', 'Юр. лицо') : \Yii::t('app', 'Физ. лицо');
                } else {
                    $paidType[] = 'Промо-код';
                }

                $row['Price'] += $price;
                $datePay[] = $formatter->format('dd MMMM yyyy H:m', $orderItem->PaidTime);
            }
            $row['Products'] = implode(', ', $products);
            $row['DatePay']  = implode(', ', array_unique($datePay));
            $row['PaidType'] = implode(', ', array_unique($paidType));
        }
    }

    /** @var null|array */
    private $rowMap = null;

    /**
     * Схема, описывающая расположения значений в таблице
     * @return array
     */
    private function getRowMap()
    {
        if ($this->rowMap === null) {
            $map = [
                'RUNET-ID' => 'RUNET-ID',
                'LastName' => 'Фамилия',
                'FirstName' => 'Имя',
                'FatherName' => 'Отчество',
                'Company' => 'Компания',
                'Position' => 'Должность',
                'Email' => 'Email',
                'Phone' => 'Телефон',
                'Birthday' => 'Дата рождения',
                'Role' => 'Статус на мероприятии',
                'Products' => 'Приобретенные товары',
                'Price' => 'Cумма оплаты',
                'PaidType' => 'Тип оплаты',
                'DateRegister' => 'Дата регистрации на мероприятие',
                'DatePay' => 'Дата оплаты участия',
                'DateBadge' => 'Дата выдачи бейджа',
            ];

            if ($this->hasExternalId()) {
                $map['ExternalId'] = 'Внешний ID';
            }
            $this->rowMap = $map;
        }
        $this->fillUsersData();
        return $this->rowMap;
    }

    /**
     * Основная критерия для выборки участников
     * @return \CDbCriteria
     */
    private function getCriteria()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $roles = $request->getParam('roles');

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Participants' => ['on' => '"Participants"."EventId" = :EventId', 'params' => [
                'EventId' => $this->getEvent()->Id
            ], 'together' => false],
            'Employments' => ['together' => false],
            'Employments.Company' => ['together' => false],
            'LinkPhones.Phone' => ['together' => false]
        ];
        $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';

        $command = \Yii::app()->getDb()->createCommand();
        $command->select('EventParticipant.UserId')->from('EventParticipant');
        $command->where('"EventParticipant"."EventId" = '.$this->getEvent()->Id);
        if (!empty($roles)) {
            $command->andWhere(['in', 'EventParticipant.RoleId', $roles]);
        }
        $criteria->addCondition('"t"."Id" IN ('.$command->getText().')');
        return $criteria;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getUserData(User $user)
    {
        if (isset($this->usersData[$user->Id])) {
            return $this->usersData[$user->Id];
        }
        return [];
    }

    /** @var array */
    private $usersData = [];

    /**
     * @return array
     */
    private function fillUsersData()
    {
        $initMap = false;
        $data = UserData::model()->byEventId($this->getEvent()->Id)->byDeleted(false)->findAll();
        foreach ($data as $item) {
            $definitions = $item->getManager()->getDefinitions();
            /** @var Definition $definition */
            foreach ($definitions as $definition) {
                if ($initMap === false) {
                    $this->rowMap[$definition->name] = $definition->title;
                }
                $this->usersData[$item->UserId][$definition->name][] = $definition->getPrintValue($item->getManager());
            }
            $initMap = true;
        }
        return $this->usersData;
    }

    /** @var null|bool */
    private $hasExternalId = null;

    /**
     * @return bool
     */
    private function hasExternalId()
    {
        if ($this->hasExternalId === null) {
            $this->hasExternalId = false;
            if ($this->getApiAccount() !== null) {
                $this->hasExternalId = ExternalUser::model()->byAccountId($this->getApiAccount()->Id)->exists();
            }
        }
        return $this->hasExternalId;
    }

    /** @var bool|Account|null */
    private $apiAccount = false;

    /**
     * @return Account|null
     */
    private function getApiAccount()
    {
        if ($this->apiAccount === false) {
            $this->apiAccount = Account::model()->byEventId($this->getEvent()->Id)->find();
        }
        return $this->apiAccount;
    }
}
