<?php

use application\components\controllers\AdminMainController;

class OneuseController extends AdminMainController
{
    public function actionCompetence46()
    {

        $c3 = new \competence\models\test\mailru2016_prof\C3(
            \competence\models\Question::model()->byTestId(46)->byCode('C3')->find()
        );

        $regionDistribution = [];
        $fullCount = 0;
        $results = \competence\models\Result::model()->byTestId(46)->byFinished(true)->findAll();
        foreach ($results as $results) {
            $data = $results->getResultByData();
            if (isset($data['S1']['value']) && in_array($data['S1']['value'], [1,2]) && !empty($data['C3']['value'])) {
                $fullCount++;

                $name = $c3->values[$data['C3']['value']];
                $regionDistribution[$name]++;
            }
        }



        echo $fullCount;
        echo '<pre>';
        arsort($regionDistribution);
        print_r($regionDistribution);
    }

    public function actionExportUserDataFiles()
    {
        $event = \event\models\Event::model()->findByPk(1995);
        $zipPath = \Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'event' . DIRECTORY_SEPARATOR . $event->IdName . '_export.zip';
        $definitionName = 'StudentsList';

        $zip = new \ZipArchive();
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $zip->open($zipPath, \ZIPARCHIVE::CREATE);
        $participants = \event\models\Participant::model()->byEventId($event->Id)->findAll();
        foreach ($participants as $participant) {
            $user = $participant->User;
            $row  = array_pop($event->getUserData($user));
            if (empty($row) || !isset($row->getManager()->$definitionName)) {
                continue;
            }
            $file = $row->getManager()->$definitionName;
            $extension = substr($file, strrpos($file, '.'));
            $zip->addFile($file, $user->RunetId . $extension);
        }
        $zip->close();
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="export.zip"');
        header('Content-Length: '.filesize($zipPath));
        readfile($zipPath);
    }




    public function actionExportCustomDataFiles()
    {
        $zipPath = \Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . 'iri_export.zip';

        $zip = new \ZipArchive();
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $zip->open($zipPath, \ZIPARCHIVE::CREATE);
        $ids = [9971,208504,13068,295538,295548,393201,253199,449437,116210,396743,411899,421720,14364,419734,268910,31911,152346,271051,268084,272049,52719,275761,123398,370902,45848,123398,374676,420616,454453,117796,357912,445955,136881,165208,439561,445942,265575,439620,439460,49766,1201,172001,240715,469,56172,42647,246053,2889,1767,330555,842,595,28304,97684,88689,10935,356250,2535,251832,268580,9174,33313,200349,320678,10414,16493,29165,273593,30095,266320,3326,355142,117858,14081,498,13165,199791,55266,30196,30200,107283,273892,230362,11324,298189,30052,272031,84091,8891,327415,96672,1995,439334,401773,53905,15460,14645,95541,261310,28324,97232,210315,439557,454,191281,40074,189441,373895,52799,447120,1437,51228,41657,15918,12131,374507,169000,108757,163142,2624,124493,8894,744,319239,372996,116509,185217,113569,365964,36621,2718,54040,50723,165410,17991,29188,31033,356335,144793,273735,13880,82700,373898,31113,169154,13697,200403,12959,105990,284965,356159,4884,31227,15219,126427,271110,2346,946,17855,1602,171461,51475,355367,17833,200101,191305,452084,116243,101951,14822,372261,320746,373000,13671,189135,152317,356150,206572,29106,210886,273804,171753,356066,356014,515,31606,31609,144563,356431,20997,17438,9890,152259,13851,324137,19072,356294,439561,41919,14510,172244,320679,50864,39948,17750,7702,106632,45848,16182,152499,31996,117089,207672,123221,7451,131475,356951,123826,81326,114995,50721,123169,230863,324134,15712,117950,128735,54244,372892,356366,54867,200878,355257,149301,601,244936,439404,85925,245871,194315,192813,96576,86039,85585,966,372875,356547,356362,95163,53502,19736,198776,98320,19280,162687,231418,373899,10513,53951,29093,274037,56083,327401,149708,269583,131298,101545,147761,273731,54148,373900,14502,192222,53517,350768,92082,107331,118967,81563,2337,238287,14865,15309,44330,106231,163936,373901,149290,94455,207316,2574,200267,4866,86283,421438,355980,284974,2277,439236,372883,117934,33015,168960,246020,10418,95089,13528,13876,250809,49456,116871,105371,18155,186946,13438,1395,12615,141745,50142,9809,129235,16533,725,45438,108697,29978,1756,18242,289059,33465,232919,152236,198274,244697,35587,7453,337,127626,372884,10855,60444,13062,356361,311994,129283,147057,88067,15614,327614,148892,447101,158470,129996,169147,118930,33695,207293,2731,54711,328562,1150,271048,10752,198919,50615,188869,33862,33868,1677,611,198979,9971,320724,34011,163962,1239,108414,447465,117176,373903,17261,273571,172724,427,374505,118627,256846,356572,4180,14605,34359,356421,249948,14246,117222,19582,7325,343,372891,198419,79368,107296,34520,106794,102968,450103,116543,190340,115462,15154,439278,40530,117117,169359,164492,264176,19606,14287,266157,29984,13681,356085,174347,318930,34922,127702,148769,34936,122155,29917,318338,356296,285006,84787,123412,185152,374509,356098,254304,191276,53744,29524,13761,29111,13421,82832,372,6878,320669,191325,371495,13463,96335,13473,200119,375306,124317,2216,318379,116876,149631,300004,197127,83585,122337,1059,297490,82630,91535,192798,41297,129390,15769,356411,372995,16846,41784,13881,166402,356200,29334,164783,265767,356019,207833,49760,87610,29396,356328,46244,92160,105749,55310,43425,10519,349799,119918,158078,124347,54453,172414,44701,8627,96223,118084,117506,31259,142308,236168,1660,356103,1320,805,17595,144880,17837,14912,295022,122948,356468,3271,325344,14585,13736,240488,86741,117153,318592,357641,231748,54902,97853,811,43843,14996,374504,115264,171732,149654,107156,142648,13771,87871,162840,447370,198978,13068,6229,372878,252895,14262,9734,372881,13045,169709,373002,12598,322072,37497,868,14493,14324,163235,130057,447112,150054,91076,49674,186770,36998,15132,29157,43074,95829,144223,24543,142400,575,22662,297926,130650,118964,356070,142461,34130,84089,171544,268638,82259,30076,2319,124908,54851,447473,401772,198446,97844,127751,114647,17601,269344,34063,265979,29462,167319,170775,911,92266,13084,34367,115099,34484,15479,15012,29947,327631,54560,1465,29881,1807,92136,1212,83504,733,241832];
        $participants = \user\models\User::model()->findAllBySql('SELECT * FROM "User" WHERE "RunetId" IN ('.implode(',', $ids).')');

        foreach ($participants as $participant) {
            /** @var \user\models\User $user */
            $user = $participant;
            $zip->addFile($user->getPhoto()->getOriginal(true), $user->RunetId . '.jpg');
        }
        $zip->close();
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="export.zip"');
        header('Content-Length: '.filesize($zipPath));
        readfile($zipPath);
    }





    public function actionInviteGenerator()
    {
        for ($i= 0; $i <= 30; $i++) {
            $invite = new \event\models\Invite();
            $invite->EventId = 2213;
            $invite->RoleId  = 1;
            $invite->Code = \application\components\utility\Texts::GenerateString(12);
            $invite->save();
            echo $invite->Code . '<br/>';
        }
    }

    /** Создает частие мероприятий и товары для них на основе программы */
    public function actionSectionToEventPart()
    {
        $id = 2226;
        /*
        $criteria = new \CDbCriteria();
        //$criteria->addNotInCondition('"t"."Id"', [2598,2599,2600,2644,2645,2646,2647,2648]);
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
            $price->StartTime = '2015-09-23 00:00:00';
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