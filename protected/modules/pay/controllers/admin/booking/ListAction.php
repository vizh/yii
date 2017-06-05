<?php
namespace pay\controllers\admin\booking;

use pay\components\admin\Rif;
use pay\models\OrderItem;
use pay\models\RoomPartnerBooking;

class ListAction extends \CAction
{
    private $hotel = null;
    protected $list = [];

    public function run()
    {
        $this->hotel = \Yii::app()->getRequest()->getParam('hotel', Rif::HOTEL_P);
        $this->partnerBooking($this->hotel);
        $this->mainBooking($this->hotel);
        $this->rifBooking();
        usort($this->list, [$this, 'sort']);
        $this->getController()->render('list', ['list' => $this->list, 'hotel' => $this->hotel]);
    }

    /**
     * @param ListItem $item1
     * @param ListItem $item2
     * @return int
     */
    private function sort($item1, $item2)
    {
        $name1 = trim($item1->UserName);
        $name2 = trim($item2->UserName);

        if ($name1 > $name2) {
            return 1;
        } else if ($name1 < $name2) {
            return -1;
        }
        return 0;
    }

    /**
     * @param array $list
     * @param string $hotel
     * @return array
     */

    private function partnerBooking($hotel)
    {
        $bookings = RoomPartnerBooking::model()->byEventId(\Yii::app()->params['AdminBookingEventId'])->findAll();
        foreach ($bookings as $booking) {
            $manager = $booking->Product->getManager();
            $people = json_decode($booking->People);
            if (!empty($people) && $manager->Hotel == $hotel) {
                foreach ($people as $name) {
                    if (!empty($name)) {
                        $item = new ListItem();
                        $item->UserName = $name;
                        $item->Housing = $manager->Housing;
                        $item->Number = $manager->Number;
                        $this->list[] = $item;
                    }
                }
            }
        }
        return $this->list;
    }

    /**
     * @param array $list
     * @return array
     */

    private function rifBooking()
    {
        $command = Rif::getDb()->createCommand();
        $together = $command->select('*')->from('ext_booked_person_together')->queryAll();
        foreach ($together as $row) {
            if (array_key_exists($row['ownerRunetId'], $this->list)) {
                $item = new ListItem();
                $item->UserName = $row['userName'];
                $item->Housing = $this->list[$row['ownerRunetId']]->Housing;
                $item->Number = $this->list[$row['ownerRunetId']]->Number;
                $this->list[] = $item;
            }
        }
        return $this->list;
    }

    /**
     * @param array $list
     * @param string $hotel
     * @return array
     */

    private function mainBooking($hotel)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Product.Attributes', 'Owner.Settings'];
        $criteria->addCondition('"Product"."ManagerName" = \'RoomProductManager\'');
        $orderItems = OrderItem::model()->byEventId(\Yii::app()->params['AdminBookingEventId'])->byPaid(true)->findAll($criteria);
        foreach ($orderItems as $orderItem) {
            $manager = $orderItem->Product->getManager();
            if ($manager->Hotel == $hotel) {
                $item = new ListItem();
                $item->UserName = $orderItem->ChangedOwner == null ? $orderItem->Owner->getFullName() : $orderItem->ChangedOwner->getFullName();
                $item->Housing = $manager->Housing;
                $item->Number = $manager->Number;
                $this->list[$orderItem->Owner->RunetId] = $item;
            }
        }
        return $this->list;
    }
}

class ListItem
{
    public $UserName;
    public $Housing;
    public $Number;
}