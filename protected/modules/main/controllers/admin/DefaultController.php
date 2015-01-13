<?php

use event\models\Participant;
use pay\models\OrderItem;

class DefaultController extends \application\components\controllers\AdminMainController
{

  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionTest()
  {
    $template = \mail\models\Template::model()->byActive()->bySuccess(false)->find(['order' => '"t"."Id" ASC']);

    var_dump($template);
  }

  public function actionCompetence()
  {
    $criteria = new CDbCriteria();
    $criteria->addCondition('"t"."TestId" = :TestId');
    $criteria->params = ['TestId' => 1];
    /** @var \competence\models\Result[] $results */
    $results = \competence\models\Result::model()->findAll($criteria);

    $users = [];
    foreach ($results as $result)
    {
      $data = $result->getResultByData();
      $question = new \competence\models\tests\mailru2013\C6(null);
      if (array_key_exists(get_class($question), $data))
      {
        $users[] = $result->UserId;
      }
    }


    //echo implode(', ', $users);
  }

  public function actionCompetence2()
  {
    $questionClasses = ['B3_1', 'B3_2', 'B3_3', 'B3_4', 'B3_5', 'B3_6', 'B3_7', 'B3_8', 'B3_9', 'B3_10', 'B3_11', 'B3_12', 'B3_13', 'B3_14', 'B3_15', 'B3_16'];

    $criteria = new CDbCriteria();
    $criteria->addCondition('"t"."TestId" = :TestId');
    $criteria->params = ['TestId' => 2];
    /** @var \competence\models\Result[] $results */
    $results = \competence\models\Result::model()->findAll($criteria);

    $usersId = [];
    foreach ($questionClasses as $class)
    {
      $usersId[$class] = [];
    }

    foreach ($results as $result)
    {
      $data = $result->getResultByData();
      foreach ($questionClasses as $class)
      {
        $full = '\competence\models\tests\runet2013\\'.$class;
        $question = new $full(null);
        if (array_key_exists(get_class($question), $data))
        {
          $usersId[$class][] = $result->UserId;
        }
      }
    }

    foreach ($usersId as $key => $values)
    {
      echo '<strong>'. $key . '</strong>: ' . count(array_unique($values)) . '<br>';
      $criteria = new CDbCriteria();
      $criteria->addInCondition('"t"."Id"', $values);
      $users = \user\models\User::model()->findAll($criteria);
      foreach ($users as $user)
      {
        echo $user->RunetId . ' ' . $user->getFullName() . '<br>';
      }
      echo '<br><br>';
    }


    //echo implode(', ', $users);
  }


  public function actionPayinfo()
  {
    $eventId = 425;

    $criteria = new CDbCriteria();
    $criteria->order = '"t"."Id"';

    /** @var \pay\models\Order[] $orders */
    $orders = \pay\models\Order::model()->byEventId($eventId)
        ->byPaid(true)->byBankTransfer(false)->findAll($criteria);

    $total = 0;
    foreach ($orders as $order)
    {
      $price2 = 0;
      $collection = \pay\components\OrderItemCollection::createByOrder($order);
      foreach ($collection as $item)
      {
        if ($item->getOrderItem()->Paid)
        {
          $price2 += $item->getPriceDiscount();
        }
      }

      $price = $order->getPrice();
      $total += $price;
      echo $order->Id . ': ' . $price . ' ' . $price2 . ' ' . $order->Total . '<br>';
    }

    echo '<br><br><br><br>' . $total;
  }

  public function actionExport()
  {
    return;
    $participants = \event\models\Participant::model()->byEventId(647)->findAll();
    $userIdList = [];
    foreach ($participants as $participant)
    {
      $userIdList[] = $participant->UserId;
    }

    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."ExitTime" IS NULL OR "t"."ExitTime" > NOW()');
    /** @var \commission\models\User[] $comissionUsers */
    $comissionUsers = \commission\models\User::model()->findAll($criteria);

    /** @var \user\models\User[] $users */
    $users = [];
    foreach ($comissionUsers as $comissionUser)
    {
      if (!in_array($comissionUser->UserId, $userIdList) && !isset($users[$comissionUser->UserId]))
      {
        $users[$comissionUser->UserId] = $comissionUser->User;
      }
    }

    $event = \event\models\Event::model()->findByPk(647);
    $event->skipOnRegister = true;
    $role = \event\models\Role::model()->findByPk(33);

    foreach ($users as $user)
    {
      $event->registerUser($user, $role);
    }
    echo count($users);
  }

  public function actionProducts()
  {
    echo 0;
    return;
    $runetIds = [166562, 166563, 166564, 166565, 166567, 166568, 166569, 166570, 166572, 166573, 166575, 166577, 166578, 166579, 166580, 166581, 166582, 166583, 166584, 166585, 97432, 166586, 166587, 166588, 166589, 166590, 166592, 166593, 166594, 166595, 166596, 166597, 166598, 166599, 166600, 166601, 166602, 166603, 166604];

    $productIds = [1309, 1387, 1391, 1392];

    $criteria = new CDbCriteria();
    $criteria->addInCondition('"t"."RunetId"', $runetIds);
    $users = \user\models\User::model()->findAll($criteria);

    $criteria = new CDbCriteria();
    $criteria->addInCondition('"t"."Id"', $productIds);
    $products = \pay\models\Product::model()->findAll($criteria);

    $payer = \user\models\User::model()->byRunetId(167351)->find();

    foreach ($users as $user)
    {
      foreach ($products as $product)
      {
        $orderItem = \pay\models\OrderItem::model()
            ->byPayerId($payer->Id)->byOwnerId($user->Id)
            ->byProductId($product->Id)->byDeleted(false);
        if (!$orderItem->exists())
        {
          $product->getManager()->createOrderItem($payer, $user);
        }
      }
    }
  }

    public function actionSoftool()
    {
        $roleLinks = [
            38 => 3068,
            86 => 3069,
            6 => 3070
        ];
        $riwEventId = 889;
        $softoolEventId = 1454;

        $riwParticipantRole = 1;

        $subSelect = 'SELECT "OwnerId" FROM "PayOrderItem" WHERE "ProductId" IN (3068, 3069, 3070)';
        $select = 'SELECT "UserId", "RoleId" FROM "EventParticipant" WHERE "EventId" = :EventId AND "UserId" NOT IN ('.$subSelect.')';

        $command = Yii::app()->getDb()->createCommand($select)->bindValue('EventId', $softoolEventId);

        $users = $command->queryAll();

        foreach ($users as $user) {
            $userId = $user['UserId'];
            $roleId = $user['RoleId'];
            if (!isset($roleLinks[$roleId])) {
                Yii::log(sprintf('НЕ найден товар для RoleId=%s и UserId=%s', $roleId, $userId), CLogger::LEVEL_ERROR);
                continue;
            }
            if (!Participant::model()->byEventId($riwEventId)->byUserId($userId)->exists()) {
                $participant = new Participant();
                $participant->EventId = $riwEventId;
                $participant->UserId = $userId;
                $participant->RoleId = $riwParticipantRole;
                $participant->save();
            }

            $orderItem = new OrderItem();
            $orderItem->PayerId = $userId;
            $orderItem->OwnerId = $userId;
            $orderItem->ProductId = $roleLinks[$roleId];
            $orderItem->Paid = true;
            $orderItem->PaidTime = date('Y-m-d H:i:s');
            $orderItem->save();
        }

        echo 'DONE! Added: '.count($users);
    }

    public function actionPremia()
    {
        $riwEventId = 889;
        $premiaProductId = 3071;

        $subSelect = 'SELECT "OwnerId" FROM "PayOrderItem" WHERE "ProductId" = 3071';

        $subSelectUsers = 'SELECT "Id" FROM "User" WHERE "RunetId" IN (19468,144103,149408,17991,55070,28890,109153,170450,138505,170448,31946,87871,158357,186986,158434,5469,9734,1499,149403,124931,142702,239330,18310,125071,6562,1438,8891,19238,106635,97150,43271,130854,18242,125023,107551,119160,265522,168960,254255,12735,103542,12574,12371,12215,172287,197190,12424,12089,168471,161716,171226,172023,127332,200169,118827,200159,139894,139525,109066,115650,158078,2216,610,50891,28304,131738,37083,95300,47477,55582,123412,124347,16493,86283,29628,17710,130003,15712,371,97684,169000,21309,105522,110845,33313,99779,152535,29106,139406,12131,2889,95102,134978,198667,235535,115275,170965,55266,102931,94952,12615,42208,41634,85583,85611,12781,39474,15095,107296,140871,10418,119287,240863,98728,117868,22727,142496,11409,372,13252,12147,22575,13421,200977,97341,97848,108257,138509,97336,247026,122573,1752,13084,814,156226,40318,7702,14203,15627,832,37064,17995,6229,210077
,169047,10752,14076,167793,172935,30926,127269,107083,34026,52787,209566,231709,16228,123759,14230,156787,106982,97532,117154,131401,149453,131062,169709,15056,15769,85925,185785,168598,130286,142707,137158,14714,403,52720,253964,29892,29344,149273,173618,158478,46419,91940,131825,33483,194195,132815,132155,118241,167815,130941,12663,167816,97558,149561,50891,172787,200891,11056,158435,84203,138370,181419,123389,29666,149397,44314,29334,123252,34462,9686,48523,28304,114995,193905,108112,198978,842,107159,107156,173977,173985,198004,7163,113458,112860,106632,128639,49844,32705,17693,14822,91396,88913,30926,123125,86941,42933,118913,137232,97523,10316,40467,82511,18681,14103,610,188861,10414,200097,33862,22636,198242,609,180506,40007,50424,14917,113640,1480,29609,42964,17776,82583,198235,29716,611,2202,130148,125198,173258)';

        $select = 'SELECT "UserId", "RoleId" FROM "EventParticipant" WHERE

        "EventId" = :EventId AND ("RoleId" = :RoleId OR "UserId" IN ('.$subSelectUsers.') )

        AND "UserId" NOT IN ('.$subSelect.')';

        $command = Yii::app()->getDb()->createCommand($select)->bindValue('EventId', $riwEventId)->bindValue('RoleId', 3);

        $users = $command->queryAll();

        foreach ($users as $user) {
            $userId = $user['UserId'];


            $orderItem = new OrderItem();
            $orderItem->PayerId = $userId;
            $orderItem->OwnerId = $userId;
            $orderItem->ProductId = $premiaProductId;
            $orderItem->Paid = true;
            $orderItem->PaidTime = date('Y-m-d H:i:s');
            $orderItem->save();
        }

        echo 'DONE! Added: '.count($users);
    }

    public function actionDevconphones()
    {
        echo 'done';
        exit;

        $users = [['an205@list.ru', '  89169245356', 'Россия', 'Москва'], ['kbondarenko@epicor.com', '  84957995666', 'россия', 'Москва'], ['abokarev@epicor.com', '  84957995666', 'Россия', 'Москва'], ['hr@ruswizards.com', '  88634319100', 'Россия', 'Таганрог'], ['anton.s.morozov@gmail.com', '  89528968684', 'Россия', 'Томск'], ['artur.drobinskiy@rubius.com', '  89539226846', 'Россия', 'Томск'], ['grisha.naychenko@gmail.com', '  89807071000', 'Россия', 'Ярославль'], ['a.fr2015@yandex.ua', '  380931906083', 'украина', 'одесса'], ['harchenko.p@digdes.com', '  89217544002', 'Россия', 'Санкт-Петербург'], ['moat1981@gmail.com', '  89262353351', 'Россия', 'Москва'], ['mevgenich@gmail.com', '  89265426303', 'Россия', 'Москва'], ['mcgee@live.ru', '  79164556832', 'Россия', 'Москва'], ['dmitriy.smirnov@gmail.com', '  79263298626', 'Россия', 'Москва'], ['andreyp@wildapricot.com', '  89151652794', 'Россия', 'Москва'], ['dmitry.muh@live.ru', '  89162723601', 'Россия', 'Зеленоград'], ['svetarightnow@mail.ru', '  79160762746', 'Россия', 'г. Москва'], ['northwind@wildapricot.com', '  89264368279', 'Россия', 'Москва'], ['sergey@zwezdin.com', '  79090746850', 'Россия', 'Челябинск'], ['denis39@mail.ru', '  89152749140', 'Россия', 'Москва'], ['M.Kravetz@axitech.ru', '  89153770990', 'Россия', 'Москва'], ['alexfdev@gmail.com', '  89261113846', 'Российская Федерация', 'Долгопрудный'], ['heimann.andrey@gmail.com', '  89232462630', 'Россия', 'Новосибирск'], ['SStrelkovn@yandex.ru', '  89636085025', 'РФ', 'Москва'], ['goryachev@mdmbank.com', '  89265565492', 'РФ', 'Москва'], ['bolotov@mdmbank.com', '  89152130880', 'Россия', 'Москва'], ['sashemetov@mail.ru', '  9035613312', 'Россия', 'Москва'], ['makista@yandex.ru', '  9099481188', 'Россия', 'Москва'], ['nefremov@gmail.com', '  89261228834', 'Российская Федерация', 'Москва'], ['tarasovm@bmail.ru', '  9099481188', 'Россия', 'Москва'], ['overmuch@yandex.ru', '  79159853808', 'Россия', 'Ярославль'], ['omb@inbox.ru', '  89037656868', 'Россия', 'Москва'], ['izolotov@i-teco.ru', '  89169379080', 'Россия', 'Москва'], ['mailforsanek@mail.ru', '  89043489635', 'Россия', 'Ростов-на-Дону'], ['mexahuk61@gmail.com', '  89604502728', 'Россия', 'Ростов-на-Дону'], ['constyavorskiy@live.com', '  79854924921', 'Россия', 'Москва'], ['xpl.2.1@mail.ru', '  89167841420', 'Россия', 'Москва'], ['dossx@mail.ru', '  87775986959', 'Казахстан', 'Астана'], ['denis.zibzeev@hotmail.com', '  79252631205', 'Россия', 'Москва'], ['support_dns@okapo.ru', '  662907711', 'Украина', 'Пекин'], ['d.xahok@gmail.com', '  89630994938', 'РФ', 'Пенза'], ['vectrum1980@yandex.ru', '  89505660835', 'Россия', 'Сыктывкар'], ['kilara6000@gmail.com', '  89854296716', 'Россия', 'Москва'], ['lyubov.surint@gmail.com', '  89213066669', 'Россия', 'Санкт-Петербург'], ['Stored@mail.ru', '  89015417778', 'Россия', 'Москва'], ['force.net@gmail.com', '  79023303303', 'Россия', 'Ярославль'], ['ikolupaev@hotmail.com', '  296620402', 'BY', 'Minsk'], ['vladimir.radzivil@hotmail.com', '  0447798886573', 'United Kingdom', 'London'], ['d.gordynsky@0560.ru', '  89166678128', 'Россия', 'Москва'], ['narek.p@live.ru', '  79165840643', 'Россия', 'Москва'], ['waiste15@bk.ru', '  89050606917', 'Россия', 'Астрахань'], ['abelt@izhevsk.ru', '  79090611261', 'Россия', 'Ижевск'], ['svetlana.tsyguleva@arcadia.spb.ru', '  89112256665', 'Россия', 'Санкт-Петербург'], ['brash@inbox.ru', '  89194946698', 'Россия', 'Москва'], ['vova.klyuev@breffi.ru', '  89197391091', 'Россия', 'Москва'], ['valerka@tut.by', '  375296433329', 'Беларусь', 'Минск'], ['Maloletov.M@globalspirits.com', '  89035091251', 'Россия', 'Москва'], ['Lanin.A@khortitsa.com', '  89035091811', 'Россия', 'Москва'], ['Semenov.R@globalspirits.com', '  89035091234', 'Россия', 'Москва'], ['Balakin.N@globalspirits.com', '  89035091001', 'Россия', 'Москва'], ['gorlin.d@khortitsa.com', '  89035090005', 'Россия', 'Москва'], ['norkeyn@gmail.com', '  79253229655', 'Россия', 'Москва'], ['ya.citadel@outlook.com', '  89026915690', 'Российская Федерация', 'Сургут'], ['tvt@profys.ru', '  79244569056', 'Россия', 'Улан-Удэ'], ['sona2014@mail.com', '  89171196080', 'россия', 'самара'], ['isa_ibragimov@hotmail.com', '  0771942250', 'Кыргызстан', 'Бишкек'], ['mv.afanasev@vaz.ru', '  89178211829', 'Россия', 'Тольятти'], ['startup@vk-soft.ru', '  79166108838', 'Россия', 'Москва'], ['007safin@gmail.com', '  79689356126', 'Россия', 'Москва'], ['alopatin@hotmail.com', '  996558191190', 'Кыргызстан', 'Бишкек'], ['manshindv@gmail.com', '  89198253991', 'Россия', 'Саратов'], ['NIBelousov@mephi.ru', '  84993248766', 'Россия', 'Москва'], ['OALavrov@mephi.ru', '  84993248766', 'Россия', 'Москва'], ['YOTimoshenko@mephi.ru', '  89152861018', 'Россия', 'Москва'], ['sanyakid@mail.ru', '  89175341092', 'Россия', 'Москва'], ['lolya83@mail.ru', '  89163444460', 'Россия', 'Москва'], ['kislov@aeroclub.ru', '  89169172006', 'Россия', 'Москва'], ['ashvets@actech.ru', '  89091554050', 'Россия', 'Москва'], ['pref412@gmail.com', '  380504041131', 'Украина', 'Харьков'], ['chernikov@tt-com.ru', '  79165712675', 'Россия', 'Москва'], ['a-korotkov@outlook.com', '  79271478191', 'Россия', 'Саратов'], ['buzin.victor@gmail.com', '  89312560330', 'Россия', 'Санкт-Петербург'], ['sgrankin@inbox.ru', '  79067648150', 'Россия', 'Москва'], ['coo.x63@gmail.com', '  89272660258', 'Россия', 'Самара'], ['kos9ik@live.com', '  89162858792', 'Росиия', 'Москва'], ['life9920042@gmail.com', '  79158990414', 'РФ', 'Калуга'], ['a_vikror@hotmail.com', '  380683258183', 'украина', 'киев'], ['alex.turyev@breffi.ru', '  89647233177', 'Россия', 'Москва'], ['ufa.sport@gmail.com', '  89053582631', 'Россия', 'Уфа'], ['zashibin@gmail.com', '  79022611271', 'Россия', 'Екатеринбург'], ['maxim.milovanov@ivelum.com', '  89191807620', 'Россия', 'Воронеж'], ['aleyush@outlook.com', '  79265659395', 'Россия', 'Москва'], ['sas-1c@mail.ru', '  87772303616', 'Казахстан', 'Алматы'], ['alexandernnov@yandex.ru', '  89081538271', 'Россия', 'НижнийНовгород'], ['alaris.nik@gmail.com', '  89258396630', 'Россия', 'Москва'], ['averinam@gmail.com', '  89213293443', 'Россия', 'Санкт-Петербург'], ['alexey.zakharenko@gmail.com', '  89887701702', 'Россия', 'Новороссийск'], ['pva222@rambler.ru', '  89217454879', 'Россия', 'Санк-Петербург'], ['aliaksandr_pedzko@epam.com', '  375297035519', 'Беларусь', 'Минск'], ['giardo@gmail.com', '  89629928934', 'Россия', 'Москва'], ['drovnyashin@avid.ru', '  89519508409', 'Россия', 'Пермь'], ['gonchaserg@gmail.com', '  89887624404', 'Россия', 'Новороссийск'], ['niarah@gmail.com', '  89262703636', 'Россия', 'Москва'], ['cordell@list.ru', '  89265351557', 'Россия', 'Москва'], ['serg_efr@hotmail.com', '  89104217264', 'Россия', 'Москва'], ['gydrocasper@outlook.com', '  9263480300', 'Россия', 'Москва'], ['marinafromspb@gmail.com', '  89219823398', 'Россия', 'СПб'], ['lubimtsev@avid.ru', '  89124850164', 'Россия', 'Пермь'], ['m.surikov@hotmail.com', '  375296366133', 'Беларусь', 'Минск'], ['ivanoff.nikolay@gmail.com', '  9081612979', 'Россия', 'Нижний Новгород'], ['evgeniyafarhutdinova@gmail.com', '  89124892419', 'Россия', 'Пермь'], ['alex@exsovet.ru', '  89169454883', 'Россия', 'г. Москва'], ['andr2510@mail.ru', '  89261625934', 'Россия', 'Москва'], ['mikamak@ya.ru', '  79503738380', 'Россия', 'Нижний Новгород'], ['dmitry.pogodin@gmail.com', '  89519051070', 'РФ', 'Нижний Новгород'], ['afanasievdv@vnigni.ru', '  84997816863', 'Россия', 'Москва'], ['proggmatic@outlook.com', '  79295547777', 'Россия', 'Москва'], ['multimedia@omenart.ru', '  89221470059', 'Россия', 'Екатеринбург'], ['pusiy_jan@ukr.net', '  00380633004600', 'Украина', 'Донецк'], ['kilimanjeira@gmail.com', '  89851550701', 'РФ', 'Москва'], ['rershov@factor-ts.ru', '  89031479964', 'Россия', 'Москва'], ['invoclass@hotmail.com', '  89161545405', 'Россия', 'Москва'], ['dmitry.kichinsky@gmail.com', '  79213466577', 'Россия', 'Санкт-Петербург'], ['igor.kaf@gmail.com', '  89024402903', 'Россия', 'Екатеринбург'], ['ram84@tut.by', '  80172690400', 'Беларусь', 'Минск'], ['adam415@outlook.com', '  89889365920', 'Россия', 'Нальчик'], ['bychkovea@gmail.com', '  89264994455', 'Russia', 'moscow'], ['nchapkin@mesi.ru', '  79104675787', 'Россия', 'Москва'], ['olegs@e-hitech.ru', '  79177063399', 'Россия', 'Чебоксары'], ['echzmail@gmail.com', '  79168572289', 'Россия', 'Егорьевск'], ['dwjrou@gmail.com', '  89372913907', 'Россия', 'Казань'], ['sokolov.andr@gmail.com', '  79108832401', 'Россия', 'Нижний Новгород'], ['novopashinwm@mail.ru', '  89067084653', 'Россия', 'Москва'], ['sergey.bozhko@takeda.com', '  89152110583', 'Россия', 'Москва'], ['korotkov83@mail.ru', '  79175867466', 'Россия', 'Москва'], ['Kirill.Otyutskiy@takeda.com', '  89852345725', 'Россия', 'Москва'], ['vsemenov@lanit.ru', '  89165539659', 'Россия', 'Москва'], ['ddurasau@azuregeeks.com', '  375447490013', 'Беларусь', 'Минск'], ['a.n.panasenko@gmail.com', '  9030175351', 'Россия', 'Москва'], ['zaborcev-1968@outlook.com', '  89831613753', 'Россия', 'Лесосибирск'], ['nodir-smart@mail.ru', '  998943602623', 'Узбекистан', 'Ташкент'], ['random.goodman@gmail.com', '  79262081085', 'Россия', 'Москва'], ['abramsm1a1@hotmail.com', '  79535777717', 'Россия', 'нидний новгород'], ['malykhin.evdokim@gmail.com', '  89261506336', 'Россия', 'Москва'], ['mihailefimov@outlook.com', '  9880058370', 'Россия', 'Волгоград'], ['sergey.razmyslov@gmail.com', '  89201020843', 'Россия', 'Ярославль'], ['greshnikov@actech.ru', '  89262130457', 'Россия', 'Москва'], ['bdletterbox@gmail.com', '  89201244559', 'Россия', 'Ярославль'], ['dmitry.mamay@gmail.com', '  375297551097', 'Беларусь', 'Минск'], ['katherina_911@mail.ru', '  89108107921', 'Россия', 'Ярославль'], ['ira-kuraeva91@yandex.ru', '  89159847281', 'Россия', 'Ярославль'], ['greybax@gmail.com', '  89159889398', 'Россия', 'Ярославль'], ['valera@gismeteo.com', '  89175991702', 'Россия', 'Москва'], ['alena@gismeteo.com', '  89057237469', 'Россия', 'Москва'], ['andrew.volga@gmail.com', '  9684007396', 'Россия', 'Москва'], ['m.kozylov@outlook.com', '  79054314683', 'Россия', 'Ростов-на-Дону'], ['crazy.vegetable@ya.ru', '  89324565656', 'ромсия', 'ррр'], ['dian-keht@mail.ru', '  89500145237', 'Россия', 'Санкт-Петербург'], ['skurdiukov@gmail.com', '  79219876545', 'РФ', 'Санкт-Петербург'], ['small85@mail.ru', '  89211891410', 'Россия', 'Санкт-Петербург'], ['artemmodin@gmail.com', '  79214021898', 'Россия', 'Санкт-Петербург'], ['egorov-d-s@ya.ru', '  79643818183', 'РФ', 'Санкт-Петербург'], ['grem305@hotmail.com', '  89095447160', 'Россия', 'Томск'], ['pchelin@outlook.com', '  79161022008', 'Россия', 'Москва'], ['v_2a@inbox.ru', '  89098592328', 'Россия', 'Хабаровск'], ['must-see@mail.ru', '  89244169264', 'Россия', 'Хабаровск'], ['moder_bpk1932@mail.ru', '  9177999799', 'Россия', 'Белорецк'], ['perkhov@yandex.ru', '  9266042710', 'Россия', 'Москва'], ['lorefinding@yandex.ru', '  89859239929', 'Россия', 'Химки'], ['kosolapov@outlook.com', '  79094215721', 'Россия', 'Ростов-на-Дону'], ['konstantin.i.kozlov@gmail.com', '  89111809350', 'Россия', 'С.-Пб.'], ['wanowicz@gmail.com', '  375297867933', 'Беларусь', 'Гродно'], ['petrovmp@mail.ru', '  89603560150', 'Россия', 'Саратов'], ['novaboreckii@outlook.com', '  89037840709', 'Россия', 'Москва'], ['khurshidrustamov@gmail.com', '  998909001900', 'Узбекистан', 'Ташкент'], ['alexey.builuk@gmail.com', '  79147375807', 'Россия', 'Владивосток'], ['kamenskiyas@kr-nipineft.ru', '  89233652665', 'Россия', 'Красноярск'], ['hvostt@live.ru', '  79224206466', 'Россия', 'Сургут'], ['alexei.kalduzov@gmail.com', '  79226221568', 'Россия', 'Оренбург'], ['yozka@tigraha.com', '  79129203291', 'Россия', 'Тюмень'], ['serkovigor1985@mail.ru', '  89670841455', 'Россия', 'Москва'], ['ssp.mir@gmail.com', '  89620341588', 'Россия', 'Омск'], ['kalinin_ks@outlook.com', '  79266526189', 'Россия', 'Москва'], ['zhukov@lanit.ru', '  89263324983', 'Россия', 'Москва'], ['bevzuk@pisem.net', '  79108911193', 'Россия', 'НижнийНовгород'], ['smirnovvs@gmail.com', '  79219455096', 'Россия', 'Санкт-Петербург'], ['toshik@toshik.com', '  79219620939', 'Россия', 'Санкт-Петербург'], ['Sereban@xakep.ru', '  380687802978', 'Россия', 'Симферополь'], ['illigrium@live.ru', '  89159875165', 'Россия', 'Ярославль'], ['superiorboroda@gmail.com', '  89536709412', 'Россия', 'Киров'], ['alexey.pertcev@gmail.com', '  89513157737', 'Россия', 'Курск'], ['b.garbuzov@0560.ru', '  79156890090', 'Россия', 'Москва'], ['oleg.estekhin@live.ru', '  89165076534', 'Россия', 'Москва'], ['akonyaev@gmail.com', '  79168036692', 'Россия', 'Москва'], ['loomst@gmail.com', '  89039813984', 'Росия', 'Омск'], ['i.rooless@gmail.com', '  89045276626', 'Россия', 'Курск'], ['zy@live.ru', '  9262102268', 'Россия', 'Москва'], ['v-olleus@microsoft.com', '  89187688683', 'Россия', 'Ставрополь'] ];

        foreach ($users as $fields) {
            $email = trim($fields[0]);
            $user = \user\models\User::model()->byEmail($email)->byEventId(1524)->find();
            if ($user !== null) {
                $phone = \application\components\utility\Texts::getOnlyNumbers($fields[1]);
                if (!$user->PrimaryPhoneVerify) {
                    $user->PrimaryPhone = $phone;
                    $user->PrimaryPhoneVerifyTime = null;
                    $user->save();
                } elseif ($user->PrimaryPhone !== $phone) {
                    $user->setContactPhone($phone);
                }

                $country = trim($fields[2]);
                $city = trim($fields[3]);
                $jsonData = [];
                if (!empty($country)) {
                    $jsonData['Country'] = $country;
                }
                if (!empty($city)) {
                    $jsonData['City'] = $city;
                }
                if (!empty($jsonData)) {
                    $userData = new \event\models\UserData();
                    $userData->EventId = 1524;
                    $userData->CreatorId = $userData->UserId = $user->Id;
                    $userData->Attributes = json_encode($jsonData, JSON_UNESCAPED_UNICODE);
                    $userData->save();
                }
            } else {
                echo "not find user for: " . $email . '<br>';
            }
        }
    }
}