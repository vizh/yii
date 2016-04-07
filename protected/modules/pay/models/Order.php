<?php
namespace pay\models;

use application\components\ActiveRecord;
use event\models\Event;
use mail\components\mailers\MandrillMailer;
use partner\models\PartnerCallback;
use pay\components\CodeException;
use pay\components\collection\Finder;
use pay\components\Exception;
use pay\components\MessageException;
use pay\components\OrderItemCollection;
use user\models\User;

/**
 * @property int $Id
 * @property int $PayerId
 * @property int $EventId
 * @property bool $Paid
 * @property string $PaidTime
 * @property int $Total
 * @property bool $Juridical
 * @property string $CreationTime
 * @property bool $Deleted
 * @property string $DeletionTime
 * @property bool $Receipt
 * @property int $TemplateId
 * @property string $Number
 * @property int $Type
 *
 *
 * @property OrderLinkOrderItem[] $ItemLinks
 * @property OrderJuridical $OrderJuridical
 * @property User $Payer
 * @property Event $Event
 * @property OrderJuridicalTemplate $Template
 *
 * @method Order findByPk()
 * @method Order find($condition = '', $params = [])
 * @method Order[] findAll($condition = '', $params = [])
 */
class Order extends ActiveRecord
{
    const BookDayCount = 5;
    const PayTypeJuridical = 'Juridical';

    private static $SecretKey = '7deSAJ42VhzHRgYkNmxz';

    private $viewTemplate;

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PayOrder';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'ItemLinks' => array(self::HAS_MANY, 'pay\models\OrderLinkOrderItem', 'OrderId'),
            'OrderJuridical' => array(self::HAS_ONE, 'pay\models\OrderJuridical', 'OrderId'),
            'Payer' => array(self::BELONGS_TO, 'user\models\User', 'PayerId'),
            'Event' => array(self::BELONGS_TO, 'event\models\Event', 'EventId'),
            'Template' => [self::BELONGS_TO, 'pay\models\OrderJuridicalTemplate', 'TemplateId']
        ];
    }

    /**
     * @param int $payerId
     * @param bool $useAnd
     * @return Order
     */
    public function byPayerId($payerId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."PayerId" = :PayerId';
        $criteria->params = ['PayerId' => $payerId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     *
     * @return Order
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param $longPayment
     * @param bool $useAnd
     *
     * @return Order
     */
    public function byLongPayment($longPayment, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        if ($longPayment) {
            $criteria->addInCondition('"t"."Type"', OrderType::getLong(), $useAnd);
        } else {
            $criteria->addNotInCondition('"t"."Type"', OrderType::getLong(), $useAnd);
        }

        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param $bankTransfer
     * @param bool $useAnd
     *
     * @return Order
     */
    public function byBankTransfer($bankTransfer, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        if ($bankTransfer) {
            $criteria->addInCondition('"t"."Type"', OrderType::getBank(), $useAnd);
        } else {
            $criteria->addNotInCondition('"t"."Type"', OrderType::getBank(), $useAnd);
        }

        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param bool $juridical
     * @param bool $useAnd
     * @return $this
     */
    public function byJuridical($juridical, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        if ($juridical) {
            $criteria->addInCondition('"t"."Type"', [OrderType::Juridical], $useAnd);
        } else {
            $criteria->addNotInCondition('"t"."Type"', [OrderType::Juridical], $useAnd);
        }

        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param bool $receipt
     * @param bool $useAnd
     * @return $this
     */
    public function byReceipt($receipt, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        if ($receipt) {
            $criteria->addInCondition('"t"."Type"', [OrderType::Receipt], $useAnd);
        } else {
            $criteria->addNotInCondition('"t"."Type"', [OrderType::Receipt], $useAnd);
        }

        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param bool $paid
     * @param bool $useAnd
     * @return Order
     */
    public function byPaid($paid, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($paid ? '' : 'NOT ') . '"t"."Paid"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param bool $deleted
     * @param bool $useAnd
     *
     * @return Order
     */
    public function byDeleted($deleted, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($deleted ? '' : 'NOT ') . '"t"."Deleted"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @return array Возвращает Total - сумма проведенного платежа и ErrorItems - позиции по которым возникли ошибки двойной оплаты
     */
    public function activate()
    {
        $collection = OrderItemCollection::createByOrder($this);
        $total = 0;
        $errorItems = [];
        $activations = [];

        foreach ($collection as $item) {
            if ($item->getOrderItem()->Refund) {
                continue;
            }

            $activation = $item->getOrderItem()->getCouponActivation();
            if ($item->getOrderItem()->activate($this)) {
                if ($activation !== null) {
                    $activations[$activation->Id][] = $item->getOrderItem()->Id;
                }
            } else {
                $errorItems[] = $item->getOrderItem()->Id;
            }

            $total += $item->getPriceDiscount();
        }

        foreach ($activations as $activationId => $items) {
            foreach ($items as $itemId) {
                $link = new CouponActivationLinkOrderItem();
                $link->CouponActivationId = $activationId;
                $link->OrderItemId = $itemId;
                $link->save();
            }
        }

        $this->Paid = true;
        $this->PaidTime = date('Y-m-d H:i:s');
        $this->Total = $total;
        $this->save();

        PartnerCallback::pay($this->Event, $this, strtotime($this->CreationTime));

        $event = new \CModelEvent($this, array('total' => $total));
        $this->onActivate($event);

        return ['Total' => $total, 'ErrorItems' => $errorItems];
    }

    public function onActivate($event)
    {
        $oldLanguage = \Yii::app()->getLanguage();
        $language = $this->Payer->Language != null ? $this->Payer->Language : 'ru';
        \Yii::app()->setLanguage($language);
        /** @var $sender Order */
        $sender = $event->sender;
        $class = \Yii::getExistClass('\pay\components\handlers\order\activate', ucfirst($sender->Event->IdName), 'Base');
        /** @var $mail \event\components\handlers\register\Base */
        $mail = new $class(new MandrillMailer(), $event);
        $mail->send();
        \Yii::app()->setLanguage($oldLanguage);
    }

    /**
     * Заполняет счет элементами заказа. Возвращает значение Total (сумма заказа)
     *
     * @param User $user
     * @param Event $event
     * @param int $type
     * @param array $data
     * @throws Exception
     *
     * @return int
     */
    public function create($user, $event, $type, $data = [])
    {
        if (!$account = Account::model()->byEventId($event->Id)->find()) {
            throw new CodeException(CodeException::NO_PAY_ACCOUNT, [$event->Id, $event->IdName, $event->Title]);
        }

        $finder = Finder::create($event->Id, $user->Id);
        $collection = $finder->getUnpaidFreeCollection();
        if ($collection->count() == 0) {
            throw new MessageException('У вас нет не оплаченных товаров, для выставления счета.');
        }

        PartnerCallback::tryPay($event, $user);

        $this->PayerId = $user->Id;
        $this->EventId = $event->Id;
        $this->Type = $type;
        $this->save();
        $this->refresh();

        $total = 0;
        foreach ($collection as $item) {
            $total += $item->getPriceDiscount();
            $orderLink = new OrderLinkOrderItem();
            $orderLink->OrderId = $this->Id;
            $orderLink->OrderItemId = $item->getOrderItem()->Id;
            $orderLink->save();

            if (OrderType::getIsLong($this->Type)) { //todo: костыль для РИФ+КИБ проживания, продумать адекватное выставление сроков бронирования

                if ($item->getOrderItem()->Booked != null) {
                    $item->getOrderItem()->Booked = $this->getBookEnd($item->getOrderItem()->CreationTime);
                }
                $item->getOrderItem()->PaidTime = $this->CreationTime;
                $item->getOrderItem()->save();
            }
        }

        if (OrderType::getIsLong($this->Type)) {
            $orderJuridical = new OrderJuridical();
            $orderJuridical->OrderId = $this->Id;
            if ($this->Type == OrderType::Juridical) {
                $orderJuridical->Name = $data['Name'];
                $orderJuridical->Address = $data['Address'];
                $orderJuridical->INN = $data['INN'];
                $orderJuridical->KPP = $data['KPP'];
                $orderJuridical->Phone = $data['Phone'];
                $orderJuridical->PostAddress = $data['PostAddress'];
            }
            $orderJuridical->save();
        } else {
            $orders = Order::model()
                ->byEventId($this->EventId)
                ->byPaid(false)
                ->byDeleted(false)
                ->byLongPayment(false)
                ->byPayerId($this->PayerId)
                ->findAll();

            foreach ($orders as $order) {
                if ($order->Id != $this->Id) {
                    $order->delete();
                }
            }
        }

        if (OrderType::getIsTemplate($this->Type)) {
            $template = $this->Type == OrderType::Juridical ? $account->OrderTemplate : $account->ReceiptTemplate;
            $this->TemplateId = $template->Id;
            $this->Number = $template->NumberFormat != null ? $template->getNextNumber() : $this->Id;
            $this->save();

            $event = new \CModelEvent($this, ['payer' => $user, 'event' => $event, 'total' => $total]);
            $this->onCreateOrderJuridical($event);
        } else {
            $this->Number = $this->Id;
            $this->save();
        }

        return $total;
    }

    public function onCreateOrderJuridical($event)
    {
        $oldLanguage = \Yii::app()->getLanguage();
        $language = $this->Payer->Language != null ? $this->Payer->Language : 'ru';
        \Yii::app()->setLanguage($language);
        $class = \Yii::getExistClass('\pay\components\handlers\orderjuridical\create', ucfirst($event->params['event']->IdName), 'Base');
        /** @var $mail \event\components\handlers\register\Base */
        $mail = new $class(new MandrillMailer(), $event);
        $mail->send();
        \Yii::app()->setLanguage($oldLanguage);
    }

    /**
     * @static
     * @param string $start
     * @return string format Y-m-d H:i:s
     */
    private function getBookEnd($start)
    {
        // TODO Delete after RIF
        if ($this->EventId == 2393 /* РИФ16 */) {
            return '2016-04-08 22:59:59';
        }

        $timestamp = strtotime($start);

        $days = 0;
        while ($days < self::BookDayCount) {
            $timestamp += 60 * 60 * 24;
            $dayOfWeek = intval(date('N', $timestamp));
            if ($dayOfWeek == 6 || $dayOfWeek == 7) {
                continue;
            }
            $days++;
        }

        return date('Y-m-d 22:59:59', $timestamp);
    }

    public function getPrice()
    {
        $collection = OrderItemCollection::createByOrder($this);
        $price = 0;
        foreach ($collection as $item) {
            if ($item->getOrderItem()->Refund) {
                continue;
            }
            $price += $item->getPriceDiscount();
        }
        return $price;
    }

    public function delete()
    {
        if ($this->Paid || $this->Deleted) {
            return false;
        }

        foreach ($this->ItemLinks as $link) {
            if ($link->OrderItem == null)
                continue;
            if ($link->OrderItem->Booked != null) {
                $link->OrderItem->Booked = date('Y-m-d H:i:s', time() + 5 * 60 * 60);
            }
            $link->OrderItem->PaidTime = null;
            $link->OrderItem->save();
        }

        $this->Deleted = true;
        $this->DeletionTime = date('Y-m-d H:i:s');
        $this->save();

        return true;
    }

    /**
     * Обновляет счет, в связи с возвратом заказа
     * @return bool
     */
    public function refund(OrderItem $orderItem)
    {
        if (!$this->Paid || $this->getItemLink($orderItem) === null) {
            return false;
        }

        $collection = OrderItemCollection::createByOrder($this);
        $count = 0;
        foreach ($collection as $item) {
            if ($item->getOrderItem()->Refund) {
                continue;
            }

            if ($item->getOrderItem()->Id === $orderItem->Id) {
                $this->Total -= $item->getPriceDiscount();
            }
            $count++;
        }

        if ($count == 1) {
            $this->Paid = false;
            $this->Total = null;
            $this->Deleted = true;
            $this->DeletionTime = date('Y-m-d H:i:s');
        }

        $this->save();

        return true;
    }

    /**
     * Возаращает модель связи между счетом и заказом
     * @param OrderItem $orderItem
     * @return null|OrderLinkOrderItem
     */
    public function getItemLink(OrderItem $orderItem)
    {
        foreach ($this->ItemLinks as $link) {
            if ($link->OrderItemId === $orderItem->Id) {
                return $link;
            }
        }
        return null;
    }

    public function getHash()
    {
        return substr(md5($this->Id . self::$SecretKey), 0, 16);
    }

    public function checkHash($hash)
    {
        return $hash == $this->getHash();
    }

    public function getUrl($clear = false)
    {
        if (OrderType::getIsBank($this->Type)) {
            $params = array(
                'orderId' => $this->Id,
                'hash' => $this->getHash()
            );
            if ($clear) {
                $params['clear'] = 'clear';
            }
            return \Yii::app()->createAbsoluteUrl('/pay/order/index', $params);
        } elseif ($this->Type == OrderType::MailRu) {
            return $this->OrderJuridical->UrlPay;
        }

        return '';
    }

    /**
     * @return bool
     */
    public function getIsBankTransfer()
    {
        return OrderType::getIsBank($this->Type);
    }


    /**
     * @return string
     */
    public function getPayType()
    {
        if (!OrderType::getIsBank($this->Type)) {
            /** @var $log \pay\models\Log */
            $log = \pay\models\Log::model()->byOrderId($this->Id)->find();
            if ($log !== null) {
                return $log->PaySystem;
            }
        } else {
            return self::PayTypeJuridical;
        }

        return 'unknown';
    }

    private $billData = null;

    /**
     * @return null|BillData
     */
    public function getBillData()
    {
        if (!\pay\models\OrderType::getIsBank($this->Type))
            return null;

        if ($this->billData == null) {
            $this->billData = new \stdClass();
            $this->billData->Total = 0;
            $this->billData->Data = [];

            if (!\pay\models\OrderType::getIsBank($this->Type))
                return null;

            $collection = \pay\components\OrderItemCollection::createByOrder($this);
            foreach ($collection as $item) {
                if ($item->getOrderItem()->Refund) {
                    continue;
                }

                $orderItem = $item->getOrderItem();
                $isTicket = $orderItem->Product->ManagerName == 'Ticket';
                $price = $isTicket ? $orderItem->Product->getPrice($this->CreationTime) : $item->getPriceDiscount($this->CreationTime);
                $key = $orderItem->ProductId . $price;
                if (!isset($this->billData->Data[$key])) {
                    $this->billData->Data[$key] = [
                        'Title' => $orderItem->Product->getManager()->GetTitle($orderItem),
                        'Unit' => $orderItem->Product->Unit,
                        'Count' => 0,
                        'DiscountPrice' => $price,
                        'ProductId' => $orderItem->ProductId
                    ];
                }
                $count = $orderItem->Product->getManager()->getCount($orderItem);
                $this->billData->Data[$key]['Count'] += $count;
                $this->billData->Total += $count * $price;
            }
            $this->billData->Nds = $this->billData->Total - round($this->billData->Total / 1.18, 2, PHP_ROUND_HALF_DOWN);
        }
        return $this->billData;
    }

    private $viewName = null;

    /**
     * @return null|string
     */
    public function getViewName()
    {
        if ($this->viewName == null) {
            if (!OrderType::getIsBank($this->Type))
                return null;

            if ($this->Type == OrderType::Juridical) {
                $template = $this->getViewTemplate();
                if ($template->OrderTemplateName === null) {
                    $this->viewName = 'template';
                } else {
                    $this->viewName = $template->OrderTemplateName;
                }
                $this->viewName = 'bills/' . $this->viewName;
            } else {
                $this->viewName = 'receipt/template';
            }
        }

        return $this->viewName;
    }

    /**
     * @return null|OrderJuridicalTemplate
     */
    public function getViewTemplate()
    {
        if (is_null($this->viewTemplate)) {
            if (!OrderType::getIsBank($this->Type))
                return null;

            if ($this->Template !== null) {
                $this->viewTemplate = $this->Template;
            } else {
                $account = \pay\models\Account::model()->byEventId($this->EventId)->find();
                $this->viewTemplate = $this->Type == OrderType::Juridical ? $account->OrderTemplate : $account->ReceiptTemplate;
            }
        }

        return $this->viewTemplate;
    }
}