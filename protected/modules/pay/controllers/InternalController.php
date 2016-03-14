<?php

use application\components\utility\Texts;
use pay\models\OrderItem;
use pay\models\Product;
use application\components\parsing\CsvParser;
use pay\components\managers\RoomProductManager;
use pay\models\ProductPrice;

/**
 * Class InternalController for internal purposes
 */
class InternalController extends \application\components\controllers\PublicMainController
{
    const MAX_EXECUTION_TIME = 3600;

    // Import is closed after success import for safety reasons
    const IMPORT_CLOSED = true;

    /**
     * Clears products
     */
    public function actionClear()
    {
        if (self::IMPORT_CLOSED) {
            echo 'closed';
            return;
        }

        ini_set('max_execution_time', self::MAX_EXECUTION_TIME);

        \Yii::app()->getDb()->createCommand()
            ->delete('PayProductAttribute', '"ProductId" IN (SELECT "Id" FROM "PayProduct" WHERE "EventId" = :eventId AND "ManagerName" = :managerName)', [
                ':eventId' => \Yii::app()->params['AdminBookingEventId'],
                ':managerName' => 'RoomProductManager'
            ]);

        \Yii::app()->getDb()->createCommand()
            ->delete('PayProduct', '"EventId" = :eventId AND "ManagerName" = :managerName', [
                ':eventId' => \Yii::app()->params['AdminBookingEventId'],
                ':managerName' => 'RoomProductManager'
            ]);

        echo 'OK';
    }

    public $fieldMap = [
        'TechnicalNumber' => 0,
        'Hotel' => 1,
        'Housing' => 2,
        'Category' => 3,
        'Number' => 4,
        'EuroRenovation' => 5,
        'RoomCount' => 6,
        'PlaceTotal' => 7,
        'PlaceBasic' => 8,
        'PlaceMore' => 9,
        'DescriptionBasic' => 10,
        'DescriptionMore' => 11,
        'Booking' => 12,
        'Price' => 13,
    ];

    public $fieldMapPines = [
        'TechnicalNumber' => 0,
        'Visible' => 1,
        'Hotel' => 2,
        'Housing' => 3,
        'Category' => 4,
        'Number' => 12,
        'EuroRenovation' => 5,
        'RoomCount' => 6,
        'PlaceTotal' => 9,
        'PlaceBasic' => 7,
        'PlaceMore' => 8,
        'DescriptionBasic' => 10,
        'DescriptionMore' => 17,
        'Price' => 16,
    ];

    /**
     * Imports rooms
     */
    public function actionImportrooms()
    {
        if (self::IMPORT_CLOSED) {
            echo 'closed';
            return;
        }

        ini_set('max_execution_time', self::MAX_EXECUTION_TIME);

        $parser = new CsvParser($_SERVER['DOCUMENT_ROOT'] . '/files/import_rooms_2016_15022.csv');
        $parser->SetInEncoding('utf-8');
        $parser->SetDelimeter(';');
        $results = $parser->Parse($this->fieldMap, false);
			
        //$results = array_slice($results, 200, 300); // TODO: если файл большой
        echo '<pre>';
        print_r($results);
        echo '</pre>';
        //return; // TODO: Вернуть перед импортом чтобы проверить данные

        foreach ($results as $result) {
            $product = new Product();
            $product->ManagerName = 'RoomProductManager';
            $product->Title = 'Участие в объединенной конференции РИФ+КИБ 2016 с проживанием';
            $product->EventId = Yii::app()->params['AdminBookingEventId'];
            $product->Unit = 'усл.';
            $product->EnableCoupon = false;
            $product->Public = false;
            $product->save();

            $price = new ProductPrice();
            $price->ProductId = $product->Id;
            $price->Price = Texts::getOnlyNumbers($result->Price);
            $price->StartTime = '2015-02-19 09:00:00';
            $price->save();

            if (empty($result->EuroRenovation)) {
                $result->EuroRenovation = 'нет';
            }

            if (empty($result->Housing)) {
                $result->Housing = 'Основной корпус';
            }

            foreach ($this->fieldMap as $key => $value) {
                switch ($key) {
                    case 'Booking':
                        $booking = trim($result->$key);
                        if ($booking == 'сайт') {
                            $product->getManager()->Visible = 1;
                        } else {
                            $product->getManager()->Visible = 0;
                            if ($booking == 'ОРГКОМ') {
                                $roomBooking = new \pay\models\RoomPartnerBooking();
                                $roomBooking->ProductId = $product->Id;
                                $roomBooking->Owner = 'Оргкомитет';
                                $roomBooking->DateIn = '2015-04-21';
                                $roomBooking->DateOut = '2015-04-24';
                                $roomBooking->ShowPrice = false;
                                $roomBooking->save();
                            }
                        }

                        break;
                    default:
                        $product->getManager()->$key = trim($result->$key);
                }
            }

        }

        echo 'done';
        echo '<pre>';
        print_r($results);
        echo '</pre>';
    }

    public function actionFixprice()
    {
        if (self::IMPORT_CLOSED) {
            echo 'closed';
            return;
        }

        $products = \pay\models\Product::model()
            ->byEventId(\Yii::app()->params['AdminBookingEventId'])
            ->byManagerName('RoomProductManager')
            ->findAll();

        foreach ($products as $product) {
            $price = $product->getManager()->Price;
            $price = str_replace(',', '', $price);
            $product->getManager()->Price = intval($price);

            $priceModel = $product->Prices[0];
            $priceModel->Price = intval($price);
            $priceModel->save();
        }
    }

    public function actionCreatefood()
    {
        return;
        $foods = array(
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 16 апреля, обед (пансионат)' => 600,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 16 апреля, ужин' => 500,

            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 17 апреля, завтрак' => 400,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 17 апреля, обед (пансионат)' => 600,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 17 апреля, обед (Андерсон)' => 800,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 17 апреля, ужин' => 500,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 17 апреля, банкет' => 2000,

            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 18 апреля, завтрак' => 400,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 18 апреля, обед (пансионат)' => 600,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 18 апреля, обед (Андерсон)' => 800,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 18 апреля, ужин' => 500,

            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 19 апреля, завтрак' => 400,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 19 апреля, обед (пансионат)' => 600,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 19 апреля, обед (Андерсон)' => 800,
            'Участие в объединенной конференции РИФ+КИБ 2013 с питанием: 19 апреля, ужин' => 500,
        );

        foreach ($foods as $title => $price) {
            $product = new \pay\models\Product();
            $product->ManagerName = 'FoodProductManager';
            $product->Title = $title;
            $product->EventId = 422;
            $product->Unit = 'шт.';
            $product->EnableCoupon = false;
            $product->Public = false;
            $product->save();

            $productPrice = new \pay\models\ProductPrice();
            $productPrice->ProductId = $product->Id;
            $productPrice->Price = $price;
            $productPrice->StartTime = '2013-03-14 09:00:00';
            $productPrice->save();
        }
    }

    public function actionRemovePhysicalBooked()
    {
        $orderItems = OrderItem::model()
            ->byEventId(\Yii::app()->params['AdminBookingEventId'])
            ->byPaid(false)
            ->byBooked(false)
            ->byDeleted(false)
            ->findAll();

        foreach ($orderItems as $item) {
            if ($item->delete()) {
                echo $item->Id . ' ' . $item->CreationTime . ' Booked to ' . $item->Booked . '<br>';
            }
        }
    }

    public function actionFixRoomAdditionalPrice()
    {
        if (self::IMPORT_CLOSED) {
            echo 'closed';
            return;
        }

        $products = Product::model()
            ->byEventId(\Yii::app()->params['AdminBookingEventId'])
            ->byManagerName('RoomProductManager')
            ->findAll();

        $addPrice = ['ЛЕСНЫЕ ДАЛИ' => 500, 'НАЗАРЬЕВО' => 500, 'ПОЛЯНЫ' => 500, 'СОСНЫ' => 710];

        foreach ($products as $product) {
            /** @var RoomProductManager $manager */
            $manager = $product->getManager();

            if ($manager->Hotel == 'СОСНЫ') {
                $manager->AdditionalPrice = 710;
            }
            else {
                $manager->AdditionalPrice = 500;
            }
        }
    }
}
