<?php

use application\components\controllers\AdminMainController;
use event\models\UserData;

class OneuseController extends AdminMainController
{
    public function actionRuvRif17()
    {
        for ($i = 0; $i < 20; $i++) {
            $discount = new \pay\models\Coupon();
            $discount->EventId  = 3016;
            $discount->Code = 'RUV' . $discount->generateCode();
            $discount->EndTime  = null;
            $discount->Discount = 100;
            $discount->save();
            $product = \pay\models\Product::model()->findByPk(9270);
            $discount->addProductLinks([$product]);
            echo "<b>" . $discount->Code . "</b><br/>";
        }

    }

    public function actionDevcon16Exam()
    {
        $products = [5741,5743,5745, 5742,5744,5746];
        foreach ($products as $id) {
            echo '<table border="1">';
            echo '
                <tr>
                    <td><strong>DATE</strong></td>
                    <td><strong>TIMESLOT</strong></td>
                    <td><strong>n.</strong></td>
                    <td><strong>NAME</strong></td>
                    <td><strong>MSID</strong></td>
                    <td><strong>EXAM CODE</strong></td>
                    <td><strong>VAUCHER CODE</strong></td>
                </tr>';
            $orderItems = \pay\models\OrderItem::model()->byProductId($id)->byPaid(true)->findAll();
            foreach ($orderItems as $orderItem) {
                $definitions = UserData::getDefinedAttributeValues($orderItem->Product->Event, $orderItem->getCurrentOwner());
                echo "
                    <tr>
                        <td>{$definitions['CertificationDate']}</td>
                        <td>{$definitions['CertificationTime']}</td>
                        <td></td>
                        <td>{$orderItem->getCurrentOwner()->getFullName()}</td>
                        <td>{$definitions['MSID']}</td>
                        <td>{$definitions['CertificationExamId']}<td>

                    </tr>
                ";
            }
            echo '<tr><td colspan="6"></td></tr>';
            echo '</table>';
        }

    }


    public function actionRegister2563()
    {

        exit;

        $eventId = 2563;

        $usersCards = [446999,116876,266320,14364,3326,300004,14081,498,55266,30196,107283,49766,317884,439334,401773,53905,14645,393201,439557,373895,52799,1201,93953,1437,105749,439456,15918,163142,43425,744,319239,663,113569,365964,172001,29188,469,31033,410955,374218,13697,12959,465433,42647,172414,284965,96223,4884,2889,439620,465489,171461,355367,14822,372261,17837,189135,465434,194145,123398,6878,515,31606,9890,3271,445100,411899,419734,196574,31911,106632,45848,464818,207672,7451,28304,15712,10762,54244,200878,14996,85925,245871,192813,372875,95163,19736,10513,87871,465545,131298,101545,375306,88689,53517,465354,81563,2337,447370,207316,13068,424,14262,9734,439460,421438,168960,246020,136881,169709,10418,18155,268580,12598,464648,9174,33313,141745,725,445955,108697,18242,232919,198274,28319,194150,337,60444,13062,1106,88067,158470,10414,2731,198919,420616,320669,575,188869,33862,9971,34011,191325,142461,465447,59999,17261,911,34130,84089,427,51388,170775,401772,14246,117222,253199,92266,343,327631,445942,439278,54851,29984,13681,418587,318930,1212,92136,15648,123412,298397,439521,53744,29524,208504,13421,455934];
        $usersEmpty = [30095,197127,83585,199791,208507,230362,272031,91535,8891,129390,454,40074,29334,12131,108757,2624,46244,349799,36621,158078,165410,17991,54453,13880,82700,87610,29396,200403,8627,118084,946,18120,236168,200101,452084,17595,373000,210886,31609,17438,152259,13851,325344,41919,16182,117089,123221,114995,123169,230863,324134,231748,117950,128735,173706,149301,601,439404,115264,96576,53502,171732,56083,32478,273731,14502,192222,92082,142648,295538,357912,163936,252895,372881,49456,13438,428594,129235,868,16533,163235,1756,289059,372884,147057,54711,15132,50615,611,130650,172724,15012,4180,107296,106794,116543,40530,124908,465519,264176,14287,34922,122155,318338,285006,29462,82259,30076,372,337,343,424,427,469,498,515,575,595,663,725,733,744,805,811,842,911,966,1059,1106,1150,1201,1212,1239,1320,1395,1437,1465,1602,1660,1677,1767,1807,1995,2216,2277,2319,2337,2346,2535,2574,2718,2731,2889,3271,3326,4866,4884,6229,6878,7325,7451,7453,7702,8894,9174,9734,9809,9890,9971,10414,10418,10513,10519,10752,10762,10855,10935,11324,12598,12615,12959,13045,13062,13068,13084,13165,13421,13463,13473,13528,13671,13681,13697,13736,13761,13881,14081,14246,14262,14324,14364,14493,14510,14585,14605,14645,14822,14865,14912,14996,15154,15219,15309,15460,15479,15614,15648,15712,15769,15918,16493,16846,17261,17601,17750,17833,17837,17855,18155,18242,19072,19280,19582,19606,19736,20997,22662,28304,28319,28324,29093,29106,29111,29157,29165,29188,29524,29881,29917,29947,29978,29984,30052,30196,30200,31033,31113,31227,31606,31911,31996,33015,33313,33465,33695,33862,33868,34011,34063,34130,34359,34367,34484,34520,34936,35587,36998,37497,39948,41297,41657,41784,42647,43074,43425,43843,44330,44701,45438,45848,49674,49760,49766,50142,50721,50723,50864,51228,51388,51475,52719,52799,53517,53744,53905,53951,54040,54148,54244,54560,54851,54867,54902,55266,55310,56172,59999,60444,79368,81326,81563,82630,82832,83504,84089,84091,84787,85585,85925,86039,86283,86741,87871,88067,88689,91076,92136,92160,92266,93953,94455,95089,95163,95541,95829,96223,96335,96672,97232,97844,97853,98320,101545,101951,102968,105371,105749,105990,106231,106632,107156,107283,107331,108414,108697,113569,114647,115099,115462,116210,116243,116509,116871,116876,117117,117153,117176,117222,117506,117858,117934,118627,118930,118964,118967,119918,122337,122948,123398,123412,123826,124317,124347,124493,126427,127626,127702,127751,129283,129996,130057,131298,131475,136881,141745,142308,142461,144563,144793,147761,148769,148892,149290,149631,149654,149708,152236,152317,152346,152499,158470,162687,162840,163142,163962,164492,164783,166402,167319,168960,169000,169147,169154,169359,169709,170775,171461,171544,171753,172001,172244,172414,174347,185152,185217,186770,188869,189441,190340,191276,191281,191305,191325,192798,192813,194145,194150,194315,196574,198274,198419,198446,198776,198919,198978,198979,200119,200349,200878,206572,207293,207316,207672,207833,208504,210315,231418,232919,238287,240488,240715,241832,244697,244936,245871,246020,246053,249948,251832,253199,254304,256846,261310,265767,265979,266157,266320,268084,268580,268910,269344,269583,271048,271051,271110,273571,273593,273735,273804,274037,275761,284965,295022,295548,297490,297926,298189,298397,300004,311994,317884,318379,318592,318930,319239,320669,320679,320724,320746,322072,324137,327401,327415,327614,327631,328562,355142,355257,355367,355980,356014,356019,356066,356070,356085,356098,356103,356150,356159,356200,356250,356294,356296,356328,356335,356361,356362,356366,356411,356421,356431,356468,356547,356572,356951,357641,365964,372261,372875,372878,372883,372891,372892,372995,373002,373895,373898,373899,373900,373901,373903,374218,374504,374505,374507,374509,374676,375306,393201,396743,401772,401773,410955,411899,418587,419734,421438,421720,439236,439278,439334,439456,439460,439521,439557,439561,439620,445100,445942,445955,446999,447101,447112,447120,447370,447465,447473,449437,450103,455934,463192,464648,465354,465447,465489,465545,466577];

        foreach ($usersCards as $userId) {
            $event = \event\models\Event::model()->findByPk($eventId);
            if ($event == null)
                throw new \CHttpException(404);

            $user  = \user\models\User::model()->byRunetId($userId)->find();
            $role = \event\models\Role::model()->findByPk(1);

//                $event->registerUser($user, $role);

            $badge = new \ruvents\models\Badge();
            $badge->OperatorId = 2766;
            $badge->EventId = $eventId;
            $badge->UserId = $user->Id;
            $badge->RoleId = 1;
            $badge->save();

            print $userId . "<br/>";
        }

    }

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




    public function actionGetEconomicsExperts()
    {

        // E-Commerce
        // $runetIdList = [515,611,7451,8627,10418,12598,15132,29396,30196,31033,34484,54244,81563,82832,83504,88067,95829,97844,116543,149301,169154,197127,199791,207672,273731,300004,317884,401772,411899,439460,439521,447112,447370,447473];

        // Инфраструктура
        // $runetIdList = [1677,13463,17837,55266,86283,92136,107283,115099,124317,188869,207833,322072,374218,439236];

        // Маркетинг и реклама
        // $runetIdList = [811,1767,2216,3326,8891,9174,10762,10855,12131,13880,14493,14865,14912,15012,15460,15769,16533,17601,17750,19736,29978,30200,31113,31911,32478,40530,49456,52799,60444,83585,84787,86741,87871,91535,92266,94455,95089,96335,96576,101545,101951,106231,106794,107296,107331,116243,116871,116876,117089,117117,117153,117950,118084,122948,123169,127751,130650,131298,148769,149290,152499,163142,163962,168960,169000,169147,169709,171461,172414,172724,191305,194150,194315,198446,198919,200349,251832,254304,261310,264176,268084,268910,269344,271051,273593,273735,275761,295022,318592,318930,320746,324134,327614,349799,372878,372995,373898,374509,410955];

        // Образование
        // $runetIdList = [575,842,2337,9890,9971,13068,14081,14364,22662,30095,33695,33862,42647,56083,88689,116509,128735,200101,230863,231748,245871,246053,393201,439456,447101,447465,449437];

        // Цифровой контент
        $runetIdList = [601,966,4884,13681,14246,14262,14605,18242,28319,29334,33015,36621,51475,52719,92160,108697,117222,123826,142461,152236,152259,152346,162840,230362,231418,244697,265979,71048,273571,327415,355142,374676,419734,445942,446999];

        $criteria = new \CDbCriteria();
        $criteria->order  = '"t"."LastName", "t"."FirstName", "t"."RunetId"';
        $criteria->with = [
            'Settings',
            'Employments.Company' => ['on' => '"Employments"."Primary"']
        ];
        $criteria->addInCondition('"t"."RunetId"', $runetIdList);

        $users = \user\models\User::model()->findAll($criteria);

        echo '<table>';
        foreach ($users as $user) {
            echo '<div class="t-col t-col_2 t149__col t-align_center" style="min-height: 220px">';
                echo '<img src="http://runet-id.com' . $user->getPhoto()->get90px() . '" imgfield="img" style="border-radius: 50%;" />';
                echo '<div class="t149__textwrapper">';
                    echo '<div class="t149__title t-name t-name_lg" field="title">' . $user->LastName . ' ' . $user->FirstName . '</div>';
                    echo '<div class="t149__subtitle t-descr t-descr_xxs" field="subtitle">' . $user->Employments[0]->Company->Name . '</div>';
                echo '</div>';
            echo '</div>';
        }
        echo '</div>';


    }





    public function actionInviteGenerator()
    {
        for ($i= 0; $i <= 60; $i++) {
            $invite = new \event\models\Invite();
            $invite->EventId = 2826;
            $invite->RoleId  = 167;
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