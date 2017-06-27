<?php

use api\models\Account;
use api\models\ExternalUser;
use application\components\console\BaseConsoleCommand;
use application\components\helpers\ArrayHelper;
use application\components\services\AIS;
use event\models\Event;
use event\models\Participant;
use event\models\Role;
use event\models\UserData;
use ruvents\models\Badge;
use user\models\User;

/**
 * Contains useful utils for events
 */
class EventCommand extends BaseConsoleCommand
{
    const AIS_PARTICIPANTS_EVENT_ID = 3493;
    const AIS_VOLUNTEERS_EVENT_ID = 3514;

    /**
     * Shifts for TS
     *
     * @var array
     */
    private static $shifts = [
        'Молодежные студенческие клубы, студенческий актив и студенческие СМИ' => [
            'number' => 1,
            'startDate' => '27.06',
            'endDate' => '03.07'
        ],
        'Молодые специалисты в области развития ИТ и смежных отраслей' => [
            'number' => 2,
            'startDate' => '05.07',
            'endDate' => '11.07'
        ],
        'Молодые специалисты в сфере экономики и бизнеса' => [
            'number' => 3,
            'startDate' => '13.07',
            'endDate' => '19.07'
        ],
        'Молодые руководители НКО, правозащитных и добровольческих проектов' => [
            'number' => 4,
            'startDate' => '21.07',
            'endDate' => '27.07'
        ],
        'Молодые парламентарии и политические лидеры' => [
            'number' => 5,
            'startDate' => '29.07',
            'endDate' => '04.08'
        ],
        'Молодые политологи и социологи' => [
            'number' => 6,
            'startDate' => '06.08',
            'endDate' => '12.08'
        ],
        'Молодые специалисты транспортной отрасли' => [
            'number' => 7,
            'startDate' => '14.08',
            'endDate' => '20.08'
        ],
        /* Волонтёры */
        '№1. Заезд (смены: Молодежные студенческие клубы,студенческий актив и студенческие СМИ; Молодые специалисты в области развития ИТ и смежных отраслей; Молодые специалисты в сфере экономики и бизнеса)' => [
            'number' => 1,
            'startDate' => '23.06',
            'endDate' => '20.07'
        ],
        '№2. Заезд (смены: Молодые руководители НКО, правозащитных и добровольческих проектов; Молодые парламентарии и политические лидеры; Молодые политологи и социологи, Молодые специалисты транспортной отрасли)' => [
            'number' => 2,
            'startDate' => '21.06',
            'endDate' => '20.08'
        ]
    ];

    public function actionImportCorrection()
    {
        $data = [
            ["Андреева", "Диана", "Юрьевна", "03.07", "11.07", "andianochk@mail.ru"],
            ["Анисина", "Екатерина", "Викторовна", "27.07", "04.08", "eanisina30.11@gmail.com"],
            ["Бабирук", "Валентина", "Игоревна", "19.07", "27.07", "marochkina_valen@mail.ru"],
            ["Балабекова", "Алина", "Аликовна", "26.06", "03.07", "alina_balabekova@mail.ru"],
            ["Бейдерман", "Валерия", "Владимировна", "04.08", "12.08", "vall.95.95@mail.ru"],
            ["Березин", "Алексей", "Игоревич", "04.08", "12.08", "alekseyberezin58@gmail.com"],
            ["Борисов ", "Виталий", "Александрович", "24.06", "20.08", "info@segwayvld.ru"],
            ["Васильева", "Яна", "Юрьевна", "04.08", "12.08", "yanavasileva1992@gmail.com"],
            ["Власов ", "Владимир", "Николаевич", "26.07", "30.08", ""],
            ["Волозина", "Регина", "Сергеевна", "24.06", "20.08", "regina@segwayvld.ru"],
            ["Гаврилин", "Владислав", "Владимирович", "19.07", "27.07", "pijackorgn@gmail.com"],
            ["Герасимова", "Ксения", "Александровна", "11.07", "27.07", "ksenia.stern@gmail.com"],
            ["Голичников ", "Евгений", "Николаевич", "26.07", "30.08", ""],
            ["Гончаренко", "Антонина", "Николаевна", "26.06", "03.07", "ang.23@bk.ru"],
            ["Гордеев", "Дмитрий", "Владимирович", "26.06", "20.08", "showparad@list.ru"],
            ["Горлов ", "Владимир", "Вячеславович", "26.07", "30.08", ""],
            ["Дегтярев", "Кирилл", "Сергеевич", "11.07", "19.07", "kiridegt@gmail.com"],
            ["Елисеев ", "Сергей", "Евгеньевич", "26.07", "30.08", ""],
            ["Ермолова", "Ксения", "Евгеньевна", "11.07", "19.07", "ermolka24@mail.ru"],
            ["Ефименко ", "Владимир", "Алексеевич", "24.06", "20.08", "vovaeff@yandex.ru"],
            ["Жимагулов", "Тимур", "Романович", "26.06", "22.08", "tamerlan.np@jmail.com"],
            ["Зетков ", "Игорь", "Викторович", "26.07", "30.08", ""],
            ["Иванов", "Владислав", "Игоревич", "27.07", "04.08", "vladislav4ever@mail.ru"],
            ["Иващенко", "Иван", "Анатольевич", "12.08", "20.08", "ivv1ivv@mail.ru"],
            ["Ильина", "Ольга", "Сергеевна", "04.08", "20.08", "iamilina@mail.ru"],
            ["Кадонцева", "Мария", "Владимировна", "27.07", "04.08", "nusha0@yandex.ru"],
            ["Канда", "Максим", "Витальевич", "26.06", "22.08", "95maxbest@gmai/com"],
            ["Катаев", "Дмитрий", "Викторович", "19.07", "27.07", "infernal775@bk.ru"],
            ["Кирюхин", "Алексей", "Вячеславович", "19.07", "27.07", "a-kiryukhin@list.ru"],
            ["Киселёв", "Михаил", "Александрович", "24.06", "20.08", "info@segwayvld.ru"],
            ["Кличева", "Фатима", "Олеговна", "26.06", "12.07", "fatimaklicheva@mail.ru"],
            ["Комков ", "Дмитрий", "Сергеевич", "26.07", "30.08", ""],
            ["Коновалов ", "Михаил", "Анатольевич", "26.07", "30.08", ""],
            ["Корзилова", "Татьяна", "Александровна", "11.07", "19.07", "t.korzilova@yandex.ru"],
            ["Костюков", "Эдуард", "Анатольевич", "26.06", "20.08", "djbelov@yandex.ru"],
            ["Крылов", "Семен", "Алексеевич", "24.06", "20.08", "ksalador@gmail.com"],
            ["Кумпаненко", "Анна", "Сергеевна", "19.07", "27.07", "anni.ku@yandex.ru"],
            ["Ляшков ", "Олег", "Вячеславович", "26.07", "30.08", ""],
            ["Лапшин", "Владислав", "Станиславович", "11.07", "19.07", "hownbord@gmail.com"],
            ["Лёвин ", "Валерий", "Валерьевич", "26.07", "30.08", ""],
            ["Левицкая", "Вероника", "Александровна", "26.06", "03.07", "nickushk@mail.ru"],
            ["Ломакин ", "Николай", "Иванович", "26.07", "30.08", ""],
            ["Маврин ", "Евгений", "Дмитриевич ", "24.06", "20.08", "mavrysha1996@gmail.ru"],
            ["Маковеев", "Михаил", "Сергеевич", "12.08", "20.08", "mm.ttov@gmail.com"],
            ["Малашенко ", "Евгений", "Николаевич", "26.07", "30.08", ""],
            ["Матвиенко", "Екатерина", "Олеговна", "27.07", "04.08", "reilafors@yandex.ru"],
            ["Мелёхин ", "Михаил", "Николаевич", "26.07", "30.08", ""],
            ["Мелихов", "Евгений", "Александрович", "11.07", "19.07", "weddman63@mail.ru"],
            ["Мичурин ", "Андрей ", "Васильевич", "26.07", "30.08", ""],
            ["Мотохов", "Иван", "Русланович", "03.07", "11.07", "motokhovivan1@gmail.com"],
            ["Муравьёв ", "Александр", "Анатольевич", "26.07", "30.08", ""],
            ["Мурзина", "Карина", "Антоновна", "04.08", "12.08", "karina-murzina@mail.ru"],
            ["Муругов", "Дмитрий", "Викторович", "03.07", "11.07", "murugov14@mail.ru"],
            ["Назаров ", "Михаил", "Владимирович", "26.07", "30.08", ""],
            ["Никонов", "Ярослав", "Игоревич", "03.07", "11.07", "yanikonov@yandex.ru"],
            ["Ножкин", "Евгений", "Николаевич", "26.07", "30.08", ""],
            ["Пилицкий", "Евгений", "Витальевич", "04.08", "12.08", "evgenij.piliczkij.96@mail.ru"],
            ["Погорелова", "Анастасия", "Вадимовна", "12.08", "20.08", "nastya14999@mail.ru"],
            ["Половинкина", "Олеся", "Юрьевна", "26.06", "22.08", "smart412@yandex.ru"],
            ["Полодюк ", "Сергей", "Владимирович", "26.07", "30.08", ""],
            ["Прохоров ", "Игорь", "Александрович", "26.07", "30.08", ""],
            ["Прохоров ", "Павел", "Александрович", "26.07", "30.08", ""],
            ["Рыбаков ", "Николай", "Иванович", "26.07", "30.08", ""],
            ["Савертокин", "Даниил", "Андреевич", "27.07", "04.08", "pause.vid@gmail.com"],
            ["Саламонов ", "Артём", "Анатольевич", "26.07", "30.08", ""],
            ["Самойлова", "Катарина", "Вадимовна", "26.06", "03.07", "katarina.s14@rambler.ru"],
            ["Сафонова", "Вера", "Олеговна", "03.07", "11.07", "kabinet0213@mail.ru"],
            ["Сенцов", "Алексей", "Евгеньевич", "24.06", "20.08", "a.sencoff@segwayvld.ru"],
            ["Сидоров ", "Павел", "Юрьевич", "26.07", "30.08", ""],
            ["Симоньянц", "Владимир", "Георкович", "26.06", "03.07", "ma333da@gmail.com"],
            ["Скочилова", "Юлия", "Евгеньевна", "24.06", "20.08", "skochilova86@mail.ru"],
            ["Степанцов", "Александр", "Николаевич", "24.06", "23.08", "alex.sony@bk.ru"],
            ["Терентьев ", "Дмитрий", "Вадимович", "26.07", "30.08", ""],
            ["Трохин ", "Дмитрий", "Анатольевич", "26.07", "30.08", ""],
            ["Устякина", "Татьяна", "Сергеевна", "12.08", "20.08", "milka20-06@yandex.ru"],
            ["Утина", "Светлана", "Васильевна", "12.08", "20.08", "sssvetik09@mail.ru"],
            ["Хохлова", "Анастасия", "Андреевна", "27.07", "04.08", "hohlove1991@mail.ru"],
            ["Шлепов ", "Сергей", "Владимирович", "26.07", "30.08", ""],
            ["Никаноров ", "Дмитрий", "Игоревич", "26.07", "30.08", ""],
            ["Митрохин ", "Виктор", "Алексеевич", "26.07", "30.08", ""],
            ["Данилов ", "Алексей", "Евгеньевич", "26.07", "30.08", ""],
            ["Комков ", "Сергей", "Евграфович", "26.07", "30.08", ""],
            ["Фехретдинов ", "Равиль", "Ислямович", "26.07", "30.08", ""],
            ["Титов ", "Олег", "Николаевич", "26.07", "30.08", ""],
        ];

        foreach ($data as $userData) {
            $userData = ArrayHelper::each($userData, function ($value) {
                return trim(preg_replace('@[ 　]@u', '', $value));
            });

            $users = User::model()
                ->byEventId(Event::TS17)
                ->byFirstName($userData[1])
                ->byLastName($userData[0])
                ->byFatherName($userData[2]);

            if (false === empty($userData[5])) {
                $users->byEmail($userData[5]);
            }

            $users = $users->findAll();

            if (count($users) === 0) {
                echo '0 => '.implode(', ', $userData)."\n";
                continue;
            }

            if (count($users) > 1) {
                echo count($users).' => '.implode(', ', $userData)."\n";
                continue;
            }

            $user = $users[0];

            $uData = UserData::fetch(Event::TS17, $user);
            $uDataManager = $uData->getManager();
            $uDataManager->start_date = preg_replace('#^(\d\d\.\d\d).*$#', '$1', $userData[3]);
            $uDataManager->end_date = preg_replace('#^(\d\d\.\d\d).*$#', '$1', $userData[4]);
            $uData->save();
        }
    }

    public function actionNotifyAis()
    {
        $ais = new AIS();

        // Получаем всех посетителей, пришедших к нам из АИС
        $participants = Participant::model()
            ->byEventId(Event::TS17)
            //->byAttribute('ais_registration_id', 'NOTNULL')
            ->findAll();

        foreach ($participants as $participant) {
            $udataManager = UserData::fetch(Event::TS17, $participant->UserId)->getManager();

            // Проверим, установлен ли идентификатор АИС
            if (false === empty($udataManager->ais_registration_id)) {
                // Проверим, напечатан ли бейдж?
                $isBadgeExists = Badge::model()
                    ->byUserId($participant->UserId)
                    ->byEventId(Event::TS17)
                    ->exists();

                if ($isBadgeExists === true) {
                    if ($ais->notify($udataManager->ais_registration_id)) {
                        $this->info("Success send information regID: {$udataManager->ais_registration_id}");
                    } else {
                        $this->error("Error while processing regID: {$udataManager->ais_registration_id}");
                    }
                }
            }
        }
    }

    /**
     * Imports participants from the AIS system
     *
     * @param bool $update Update the information for the last day
     * @param bool $drain
     */
    public function actionImportParticipantsFromAIS($update = false, $drain = false)
    {
        $ais = new AIS();

        $yesterday = $update
            ? (new DateTime())->sub(new DateInterval('PT15M'))->format('Y-m-d H:i:s')
            : null;

        // Find the TS event
        $event = Event::model()
            ->findByPk(Event::TS17);

        // Disable participants notification
        $event->skipOnRegister = true;
        $rolesMap = [
            self::AIS_VOLUNTEERS_EVENT_ID => Role::model()->findByPk(153 /* волонтёр */),
            self::AIS_PARTICIPANTS_EVENT_ID => Role::model()->findByPk(Role::PARTICIPANT)
        ];

        $apiAccount = Account::model()
            ->byEventId(Event::TS17)
            ->find();

        if ($apiAccount === null) {
            $this->error('Не найден api аккаунт для мероприятия!');
            return;
        }

        $total = 0;

        foreach ($rolesMap as $aisEventId => $role) {
            foreach ($ais->fetchRegistrations($aisEventId, $yesterday) as $reg) {
                if ($drain || $reg['status'] < 12 /* 12 or 13 */) {
                    continue;
                }

                $transaction = \Yii::app()->getDb()->beginTransaction();
                try {
                    $user = $this->processRegistration($reg, $event, $role, $apiAccount);

//                    $this->info("#$total: User {$user->getFullName()} is successfully registered for the event {$event->IdName}");

                    $total++;
                    $transaction->commit();
                } catch (CDbException $e) {
                    $transaction->rollback();
                    $this->error($e->getMessage());
                }
            }

            $this->log("Total count of users that have been registered: $total.");
        }
    }

    /**
     * Processes the registration of the user
     *
     * @param array $data Information about registration
     * @param Event $event
     * @param Role $role
     * @param Account $apiAccount
     * @return User Processed user
     * @throws \application\components\Exception
     */
    private function processRegistration(array $data, Event $event, Role $role, Account $apiAccount)
    {
        // Получаем всех пользователей, удовлетворяющих условию
        $participant = Participant::model()
            ->byEventId($event->Id)
            ->byAttribute('ais_registration_id', $data['registration_id'])
            ->with('User')
            ->find();

        if ($participant === null) {
            $user = new User();
            $user->Email = $data['email'];
            $user->FirstName = $data['firstname'];
            $user->LastName = $data['surname'];
            $user->FatherName = $data['pathname'];
            $user->Visible = false;

            if (false === $user->save()) {
                throw new \application\components\Exception($user);
            }

            $user->refresh();
            $user->register(false);

            echo '0';
        } else {
            $user = $participant->User;
            echo '+';
        }

        // Если у пользователя нет фотографии, то загружаем её
        if (false === $user->hasPhoto()) {
            try {
                $user->getPhoto()->save(AIS::getAvatarUrl($data['user_id']));
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        // Отписываем пользователя от всех рассылок
        if (!$user->Settings->UnsubscribeAll) {
            $user->Settings->UnsubscribeAll = true;

            if (false === $user->Settings->save()) {
                throw new \application\components\Exception($user);
            }
        }

        $event->registerUser($user, $role);

        // Создаём ExternalId посетителя
        $extuser = ExternalUser::model()
            ->byAccountId($apiAccount->Id)
            ->byUserId($user->Id)
            ->find();

        if ($extuser === null) {
            $extuser = ExternalUser::create($user, $apiAccount);
        }

        $extuser->ExternalId = $data['user_id'];

        if (false === $extuser->save()) {
            throw new \application\components\Exception($extuser);
        }

        list($dateStart, $dateEnd, $smenaNumber) = $this->detectShiftDates($data['smena_nm']);

        $food = false === empty($data['food_type'])
            ? trim(str_replace('&90 ', '', $data['food_type']))
            : 'О';

        $food = $food === 'ОбычноеВегетарианскоеМусульманское' ? 'М' : $food;
        $food = $food === 'ВегетарианскоеМусульманское' ? 'М' : $food;
        $food = $food === 'ОбычноеВегетарианское' ? 'В' : $food;
        $food = $food === 'ОбычноеМусульманское' ? 'М' : $food;
        $food = $food === 'Вегетарианское' ? 'В' : $food;
        $food = $food === 'Мусульманское' ? 'М' : $food;
        $food = $food === 'Обычное' ? 'О' : $food;
        $food = $food === 'О' ? '' : $food;

        $udata = UserData::fetch($event, $user);
        $udata->getManager()->setAttributes([
            'country' => $data['country_name'] ?: 'Россия',
            'region' => $data['socr'].' '.$data['region_name'],
            'smena' => $data['smena_nm'],
            'ais_registration_id' => $data['registration_id'],
            'team_number' => $data['twenty'],
            'start_date' => $dateStart,
            'end_date' => $dateEnd,
            'smena_no' => $smenaNumber,
            'food_type' => $food
        ]);

        if (false === $udata->save()) {
            throw new \application\components\Exception($udata);
        }

        return $user;
    }

    /**
     * Detects dates and number of the shift. It returns nulls if it can't find the shift
     *
     * @param string $shift Name of the shift
     * @return array Dates and number in the format [startDate, endDate, number]
     */
    private function detectShiftDates($shift)
    {
        if (!isset(self::$shifts[$shift])) {
            echo 'ERROR: Unbale to detect start and end dates!';
            return [null, null, null];
        }

        $data = self::$shifts[$shift];

        return [$data['startDate'], $data['endDate'], $data['number']];
    }
}
