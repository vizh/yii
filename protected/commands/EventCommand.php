<?php

use api\models\Account;
use api\models\ExternalUser;
use application\components\console\BaseConsoleCommand;
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
    const TS16 = 2783; // Территория смыслов 2016
    const TS17 = 3408; // Территория смыслов 2017
    const AR17 = 3243; // Арктика 2017
    const TV17 = 3462; // Таврида 2017

    private static $events = [];

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

    public function init()
    {
        self::$events = [
            // Таврида
//            self::TV17 => [
//                'Event' => null,
//                'Account' => null,
//                'Sources' => [
//                    3169 /* волонтёр */ => Role::model()->findByPk(153),
//                    2387 /* участник */ => Role::model()->findByPk(Role::PARTICIPANT)
//                ]
//            ],
            // Территория смыслов
            self::TS17 => [
                'Event' => null,
                'Account' => null,
                'Sources' => [
                    3514 /* волонтёр */ => Role::model()->findByPk(153),
                    3493 /* участник */ => Role::model()->findByPk(Role::PARTICIPANT)
                ]
            ]
        ];
    }

    public function actionNotifyAis()
    {
        $ais = new AIS();

        // Получаем всех посетителей, пришедших к нам из АИС
        $participants = Participant::model()
            ->byEventId([self::TS17, self::TV17])
            //->byAttribute('ais_registration_id', 'NOTNULL')
            ->findAll();

        foreach ($participants as $participant) {
            // Получаем доступ к расширенным атрибутам посетителя
            $udataManager = UserData::fetch($participant->EventId, $participant->UserId)->getManager();
            // Проверим, установлен ли идентификатор АИС
            if (false === empty($udataManager->ais_registration_id)) {
                // Проверим, напечатан ли бейдж?
                $isBadgeExists = Badge::model()
                    ->byUserId($participant->UserId)
                    ->byEventId($participant->EventId)
                    ->exists();
                // Отправляем отметку о печати бейджа в АИС
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

        $total = 0;

        foreach (self::$events as $ridEventId => $cfgEvent) {
            $event = Event::model()->findByPk($ridEventId);
            $event->skipOnRegister = true; // Не отправляем регистрационные письма

            $apiAccount = Account::model()
                ->byEventId($ridEventId)
                ->find();

            if ($apiAccount === null) {
                $this->error('Не найден api аккаунт для мероприятия!');
                return;
            }

            echo "\nОбработка посетителей {$event->IdName}: ";

            foreach ($cfgEvent['Sources'] as $aisEventId => $role) {
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
            echo "ERROR: Unbale to detect start and end dates from {$shift}!";
            return [null, null, null];
        }

        $data = self::$shifts[$shift];

        return [$data['startDate'], $data['endDate'], $data['number']];
    }
}
