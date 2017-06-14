<?php
namespace partner\components\export;

use api\models\Account;
use api\models\ExternalUser;
use application\components\attribute\Definition;
use application\components\Exception;
use application\components\helpers\ArrayHelper;
use CText;
use event\models\Participant;
use event\models\UserData;
use partner\models\Export;
use pay\components\OrderItemCollection;
use pay\models\OrderItem;
use pay\models\OrderType;
use PHPExcel;
use PHPExcel_IOFactory;
use ruvents\models\Badge;
use user\models\DocumentType;
use user\models\User;
use Yii;

class ExcelBuilder
{
    /** @var Export */
    private $export;

    /** @var array */
    private $config;

    private $rowIterator = 1;

    public function __construct(Export $export)
    {
        $this->export = $export;
        $this->config = json_decode($export->Config);

        // Если язык экспорта не указан, то устанавливаем ru
        if (empty($this->config->Language)) {
            $this->config->Language = Yii::app()->getParams()['Languages'][0];
        }
    }

    /**
     * Запуск процесса формирования excel файла с участниками
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function run()
    {
        // Попытка запуска уже отработавшей задачи
        if ($this->export->Success) {
            return true;
        }

        Yii::app()->setLanguage($this->config->Language);

        $excel = new PHPExcel();
        $excel->setActiveSheetIndex();

        $sheet = $excel->getActiveSheet();
        $sheet->setTitle(CText::truncate(Yii::t('app', 'Участники').' '.$this->export->Event->IdName, 28));

        $this->setHeaderRow($sheet);

        $users = User::model()
            ->findAll($this->getCriteria());

        $this->export->TotalRow = count($users);
        $this->export->ExportedRow = 0;

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        foreach ($users as $user) {
            $this->appendRow($sheet, $user);
            $this->export->ExportedRow++;
            // Обновляем статистику в интерфейсе
            if ($this->export->ExportedRow % 50 === 0) {
                $this->export->save();
            }
        }

        $this->export->Success = true;
        $this->export->SuccessTime = date('Y-m-d H:i:s');
        $this->export->FilePath = $this->getFilePath();

        $writer->save($this->export->FilePath);

        if (false === $this->export->save()) {
            throw new Exception($this->export);
        }

        return true;
    }

    /**
     * Устанавливает заголовки для таблицы
     * @param \PHPExcel_Worksheet $sheet
     */
    private function setHeaderRow(\PHPExcel_Worksheet $sheet)
    {
        foreach (array_values($this->getRowMap()) as $i => $value) {
            $cell = $sheet->getCellByColumnAndRow($i, $this->rowIterator);
            $cell->setValue($value);
            $cell->getStyle()->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_PATTERN_DARKGRAY);
            $cell->getStyle()->getFill()->getStartColor()->setRGB();
            $cell->getStyle()->getFont()->getColor()->setRGB('FFFFFF');
            $cell->getStyle()->getFont()->setSize(14);
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
        $formatter = Yii::app()->getDateFormatter();

        $row = $this->getBaseRow($user);

        /** @var Participant $participant */
        $participant = null;
        foreach ($user->Participants as $item) {
            if ($participant === null || $participant->Role->Priority < $item->Role->Priority) {
                $participant = $item;
            }
        }

        if ($participant !== null) {
            $row['Role'] = $participant->Role->Title;
            $row['DateRegister'] = $formatter->format('dd MMMM yyyy HH:mm', $participant->CreationTime);
            if (!empty($this->config->PartId)) {
                $row['Part'] = $participant->Part->Title;
            }
        }

        $employment = $user->getEmploymentPrimary();
        if ($employment !== null) {
            $row['Company'] = $employment->Company->Name;
            $row['Position'] = $employment->Position;
        }

        $this->fillRowPayData($user, $row);
        if (!empty($this->config->Document)) {
            $this->fillRowDocumentData($user, $row);
        }

        $badge = Badge::model()
            ->byEventId($this->export->EventId)
            ->byUserId($user->Id)
            ->orderBy('"t"."CreationTime"')
            ->find();

        if ($badge !== null) {
            $row['DateBadge'] = $formatter->format('dd MMMM yyyy HH:mm', $badge->CreationTime);
        }

        if ($this->hasExternalId()) {
            $externalUser = ExternalUser::model()
                ->byAccountId($this->getApiAccount()->Id)
                ->byUserId($user->Id)
                ->find();

            if ($externalUser !== null) {
                $row['ExternalId'] = $externalUser->ExternalId;
            }
        }

        foreach ($this->getUserData($user) as $name => $value) {
            $row[$name] = implode(';', $value);
        }

        $i = 0;
        foreach ($row as $value) {
            $sheet->setCellValueExplicitByColumnAndRow($i++, $this->rowIterator, $value, is_numeric($value)
                ? \PHPExcel_Cell_DataType::TYPE_NUMERIC
                : \PHPExcel_Cell_DataType::TYPE_STRING);
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

        $address = $user->getContactAddress();
        if ($address !== null) {
            $row['City'] = !empty($address->City) ? $address->City->Name : '';
            $row['Region'] = !empty($address->Region) ? $address->Region->Name : '';
        }

        $row['Subscription'] = (
            // если не отписался от всех
            !$user->Settings->UnsubscribeAll
            // и не отписался от текущей
            && !count($user->UnsubscribeEventMails)
        )
            ? 'да'
            : 'нет';

        return $row;
    }

    /**
     * Заполняет данные по оплате пользователя
     * @param User $user
     * @param      $row
     * @throws \pay\components\MessageException
     */
    private function fillRowPayData(User $user, &$row)
    {
        $formatter = Yii::app()->getDateFormatter();

        $orderItems = OrderItem::model()
            ->byAnyOwnerId($user->Id)
            ->byEventId($this->export->EventId)
            ->byPaid(true)
            ->byRefund(false)
            ->with(['OrderLinks.Order', 'OrderLinks.Order.ItemLinks'])
            ->findAll();

        if (empty($orderItems)) {
            return;
        }

        $datePay = [];
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
                $paidType[] = $order->Type == OrderType::Juridical ? Yii::t('app', 'Юр. лицо')
                    : Yii::t('app', 'Физ. лицо');
            } else {
                $paidType[] = 'Промо-код';
            }

            $row['Price'] += $price;
            $datePay[] = $formatter->format('dd MMMM yyyy HH:mm', $orderItem->PaidTime);
        }

        $row['Products'] = implode(', ', $products);
        $row['DatePay'] = implode(', ', array_unique($datePay));
        $row['PaidType'] = implode(', ', array_unique($paidType));
    }

    /**
     * Заполняет данные по документам для пользователя
     * @param User $user
     * @param      $row
     */
    private function fillRowDocumentData(User $user, &$row)
    {
        if (!isset($user->Documents[0])) {
            return;
        }

        $form = $user->Documents[0]->getForm($user);
        foreach ($form->getAttributes() as $name => $value) {
            $row['Document_'.$name] = $value;
        }
    }

    /** @var null|array */
    private $rowMap;

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
                'Region' => 'Регион',
                'City' => 'Город',
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
                'Subscription' => 'Получать рассылки',
            ];

            if (!empty($this->config->Document)) {
                $this->fillRowMapDocument($map);
            }

            if ($this->hasExternalId()) {
                $map['ExternalId'] = 'Внешний ID';
            }

            if (!empty($this->config->PartId)) {
                $map['Part'] = 'Часть мероприятия';
            }

            $this->rowMap = $map;
            $this->fillUsersData();
        }

        return $this->rowMap;
    }

    /**
     * Схема, описывающая расположения значений в таблице для документов пользователей
     * @param array $map
     */
    private function fillRowMapDocument(&$map)
    {
        $types = DocumentType::model()->ordered()->findAll();
        foreach ($types as $type) {
            $form = $type->getForm();
            foreach ($form->attributeLabels() as $name => $label) {
                $name = 'Document_'.$name;
                if (!isset($map[$name])) {
                    $map[$name] = 'Документ: '.$label;
                }
            }
        }
    }

    /**
     * Основная критерия для выборки участников
     * @return \CDbCriteria
     */
    private function getCriteria()
    {
        $roles = !empty($this->config->Roles) ? $this->config->Roles : [];

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Participants' => [
                'on' => '"Participants"."EventId" = :EventId'.(!empty($this->config->PartId)
                        ? ' AND "Participants"."PartId" = :PartId' : ''),
                'params' => [
                    'EventId' => $this->export->EventId,
                ],
                'together' => false,
            ],
            'Employments' => ['together' => false],
            'Employments.Company' => ['together' => false],
            'LinkPhones.Phone' => ['together' => false],
            'LinkAddress' => [
                'together' => false,
                'with' => [
                    'Address.City',
                ],
            ],
            'Documents' => ['together' => false],
            'Settings' => [
                'select' => 'UnsubscribeAll',
                'together' => false,
            ],
            'UnsubscribeEventMails' => [
                'select' => 'Id',
                'on' => '"UnsubscribeEventMails"."EventId" = :EventId',
                'params' => [
                    'EventId' => $this->export->EventId,
                ],
                'together' => false,
            ],
        ];
        $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';

        if (!empty($this->config->PartId)) {
            $criteria->with['Participants']['params']['PartId'] = $this->config->PartId;
        }

        $command = Yii::app()->getDb()->createCommand();
        $command->select('EventParticipant.UserId')->from('EventParticipant');
        $command->where('"EventParticipant"."EventId" = '.$this->export->EventId);
        if (!empty($roles)) {
            $command->andWhere(['in', 'EventParticipant.RoleId', $roles]);
        }

        if (!empty($this->config->PartId)) {
            $command->andWhere('"EventParticipant"."PartId" = '.$this->config->PartId);
        }
        $criteria->addCondition('"t"."Id" IN ('.$command->getText().')');

        return $criteria;
    }

    /**
     * @param User $user
     * @return array
     */
    private function getUserData(User $user)
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

        $data = UserData::model()
            ->byEventId($this->export->EventId)
            ->byDeleted(false)
            ->findAll();

        UserData::setEnableRawValues();
        foreach ($data as $item) {
            $definitions = $item->getManager()->getDefinitions();
            /** @var Definition $definition */
            foreach ($definitions as $definition) {
                if ($definition->translatable) {
                    $definition->translatable = false;
                    $values = $definition->getPrintValue($item->getManager());
                    foreach (Yii::app()->getParams()['Languages'] as $language) {
                        if ($initMap === false) {
                            $this->rowMap[$definition->name.'-'.$language] = $definition->title.'-'.$language;
                        }
                        $this->usersData[$item->UserId][$definition->name.'-'.$language][] = ArrayHelper::getValue($values, $language);
                    }
                    $definition->translatable = true;
                } else {
                    if ($initMap === false) {
                        $this->rowMap[$definition->name] = $definition->title;
                    }
                    $this->usersData[$item->UserId][$definition->name][] = $definition->getPrintValue($item->getManager());
                }
            }
            $initMap = true;
        }
        UserData::setDisableRawValues();

        return $this->usersData;
    }

    /** @var null|bool */
    private $hasExternalId;

    /**
     * @return bool
     */
    private function hasExternalId()
    {
        if ($this->hasExternalId === null) {
            $this->hasExternalId = $this->getApiAccount() !== null
                && ExternalUser::model()->byAccountId($this->getApiAccount()->Id)->exists();
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
            $this->apiAccount = Account::model()->byEventId($this->export->EventId)->find();
        }

        return $this->apiAccount;
    }

    private function getFilePath()
    {
        $path = Yii::getPathOfAlias("partner.data.{$this->export->EventId}.export");

        if (false === file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $path .= DIRECTORY_SEPARATOR.date('Ymd_His').'.xlsx';

        return $path;
    }
}
