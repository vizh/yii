<?php

use application\components\controllers\AdminMainController;

class OneuseController extends AdminMainController
{
    public function actionEdcrunch15Discount()
    {
        $coupon = \pay\models\Coupon::model()->byCode('EDCRUNCH14')->find();
        $participant = \event\models\Participant::model()->byEventId(1303)->findAll();
        foreach ($participant as $participant) {
            $coupon->activate($participant->User, $participant->User);
        }
    }

    public function actionInviteGenerator()
    {
        for ($i= 0; $i <= 30; $i++) {
            $invite = new \event\models\Invite();
            $invite->EventId = 2114;
            $invite->RoleId  = 1;
            $invite->Code = \application\components\utility\Texts::GenerateString(12);
            $invite->save();
            echo $invite->Code . '<br/>';
        }
    }

    /** Создает частие мероприятий и товары для них на основе программы */
    public function actionSectionToEventPart()
    {
        $id = 1995;
        /*
        $criteria = new \CDbCriteria();
        $criteria->addNotInCondition('"t"."Id"', [2598,2599,2600,2644,2645,2646,2647,2648]);
        $sections = \event\models\section\Section::model()->byEventId($id)->findAll($criteria);
        foreach ($sections as $section) {
            echo $section->Title . '<br/>';
            $part = new \event\models\Part();
            $part->EventId = $section->EventId;
            $part->Title   = $section->Title;
            $part->save();

            $product = new \pay\models\Product();
            $product->EventId = $section->EventId;
            $product->ManagerName = 'Section';
            $product->Title   = 'Участие в секции '.$section->Title;
            $product->Public  = true;
            $product->Unit    = 'чел.';
            $product->save();

            foreach (['Limit' => 50, 'SectionId' => $section->Id, 'PartId' => $part->Id, 'RoleId' => 1] as $name => $value) {
                $attribute = new \pay\models\ProductAttribute();
                $attribute->ProductId = $product->Id;
                $attribute->Name  = $name;
                $attribute->Value = $value;
                $attribute->save();
            }
        }


        $products = \pay\models\Product::model()->byEventId($id)->byManagerName('Section')->findAll();
        foreach ($products as $product) {
            $price = new \pay\models\ProductPrice();
            $price->ProductId = $product->Id;
            $price->Price = 0;
            $price->StartTime = '2015-07-28 00:00:00';
            $price->save();
        }
        */


    }

    /**
     * Заполняет адреса пользователя, у которых они не заполнены. Учитывается лог посещения.
     * Алгоритм: если с одной точки было более двух посещений с интервалом больше суток, то используется это место
     */
    public function actionAddress()
    {
        $count = 0;

        $countryMap = [
            'DE' => 1012,
            'US' => 5681,
            'LV' => 2448,
            'KZ' => 1894,
            'DK' => 1366,
            'KG' => 2303,
            'IT' => 1786,
            'GB' => 616,
            'PL' => 2897,
            'BY' => 248,
            'LT' => 2514,
            'IL' => 1393,
            'NL' => 277551,
            'CH' => 10904,
            'CZ' => 10874
        ];

        $cityCountryMap = [
            'Воронеж' => 3159,
            'Дзержинск' => 3159,
            'Донецк' => 9908,
            'Киров' => 3159
        ];

        /** @var \CDbCommand $command */
        $command = \Yii::app()->getDb()->createCommand();
        $command->select('UserLog.UserId')
            ->from('UserLog')
            ->leftJoin('UserLinkAddress', '"UserLinkAddress"."UserId" = "UserLog"."UserId"')
            ->where('"UserLinkAddress"."Id" IS NULL AND ("UserLog"."City" != \'\' OR "UserLog"."Country" != \'\')')
            ->group('UserLog.UserId')
            ->having('"count"(*) > 1');

        $i = 0;

        $userIdList = $command->queryColumn();
        foreach ($userIdList as $id) {
            $logs = \user\models\Log::model()->byUserId($id)->orderBy('"t"."CreationTime"')->findAll();

            $times = [];
            foreach ($logs as $log) {
                if (empty($log->City) && empty($log->Country)) {
                    continue;
                }
                $times[!empty($log->City) ? $log->City : $log->Country][] = new \DateTime($log->CreationTime);
            }

            $maxName  = null;
            $maxCount = 0;

            /** @var \DateTime $minDatetime */
            $minDatetime = null;

            foreach ($times as $name => $datetimes) {
                if ($maxName == null || $maxCount < count($datetimes)) {
                    $maxCount = count($datetimes);
                } else {
                    continue;
                }
                $minDatetime = null;

                /** @var \DateTime $datetime */
                foreach ($datetimes as $datetime) {
                    if ($minDatetime === null) {
                        $minDatetime = $datetime;
                        continue;
                    }

                    $dt = clone $datetime;
                    $dt->modify('-1 day');

                    if ($minDatetime->format('Y-m-d H:i:s') < $dt->format('Y-m-d H:i:s')) {
                        $minDatetime = $datetime;
                        $maxName = $name;
                    }
                }
            }

            if (!empty($maxName)) {
                $cityId    = null;
                $countryId = null;
                $regionId  = null;

                if (strlen($maxName) == 2) {
                    if (!isset($countryMap[$maxName])) {
                        echo 'Не найдена страна: ' . $maxName . '<br/>';
                        continue;
                    }
                    $countryId = $countryMap[$maxName];
                } else {
                    $cityModel = \geo\models\City::model()->byName($maxName);
                    if (isset($cityCountryMap[$maxName])) {
                        $cityModel->byCountryId($cityCountryMap[$maxName]);
                    }
                    $city = $cityModel->orderBy('"t"."Id"')->find();

                    if (empty($city)) {
                        echo 'Не найден город: ' . $maxName . '<br/>';
                        continue;
                    }

                    $cityId = $city->Id;
                    $countryId = $city->CountryId;
                    $regionId = $city->RegionId;
                }

                $address = new \contact\models\Address();
                $address->CountryId = $countryId;
                $address->RegionId = $regionId;
                $address->CityId = $cityId;
                $address->save();

                $link = new \user\models\LinkAddress();
                $link->AddressId = $address->Id;
                $link->UserId = $id;
                $link->save();

                $count++;
            };
        }
        echo 'Проставлено: ' . $count;
    }

    public function actionTersm15()
    {
        ini_set("memory_limit", "512M");
        \Yii::import('ext.PHPExcel.PHPExcel', true);
        $phpExcel = PHPExcel_IOFactory::createReader('Excel2007');
        $phpExcel = $phpExcel->load(\Yii::getPathOfAlias('application') . '/../data/event/tersm15/participants.xlsx');
        $phpExcel->setActiveSheetIndex(0);
        /** @var PHPExcel_Worksheet $sheet */
        $sheet = $phpExcel->getActiveSheet();

        foreach ($sheet->getRowIterator(2) as $row) {
            $i = $row->getRowIndex();
            $name  = $sheet->getCell('B'.$i)->getValue() . ' ' . $sheet->getCell('C'.$i)->getValue();
            $email = $sheet->getCell('E'.$i)->getValue();

            $user = \user\models\User::model()->byEmail($email)->bySearch($name, null, true, false)->find();
            if ($user !== null) {
                $sheet->setCellValue('X'.$i, $user->RunetId);
            } else {
                $cellIterator = $row->getCellIterator();
                foreach ($cellIterator as $cell) {
                    $sheet->setCellValue($cell->getCoordinate(), '');
                }
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Участники.xlsx"');
        $phpExcelWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        $phpExcelWriter->save('php://output');

    }
}