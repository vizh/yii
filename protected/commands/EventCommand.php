<?php

use api\models\Account;
use api\models\ExternalUser;
use application\components\console\BaseConsoleCommand;
use application\components\services\AIS;
use event\models\Event;
use event\models\Role;
use event\models\UserData;
use ruvents\models\Badge;
use user\models\User;

/**
 * Contains useful utils for events
 */
class EventCommand extends BaseConsoleCommand
{
    const AIS_PARTICIPANTS_EVENT_ID = 77;
    const AIS_VOLUNTEERS_EVENT_ID = 112;

    /**
     * Shifts for TS
     *
     * @var array
     */
    private static $shifts = [
        'Молодые ученые и преподаватели общественных наук' => [
            'number' => 1,
            'startDate' => '27.06',
            'endDate' => '03.07'
        ],
        'Молодые депутаты и политические лидеры' => [
            'number' => 2,
            'startDate' => '05.07',
            'endDate' => '11.07'
        ],
        'Молодые ученые и преподаватели в области IT-технологий' => [
            'number' => 3,
            'startDate' => '13.07',
            'endDate' => '19.07'
        ],
        'Молодые специалисты в области межнациональных отношений' => [
            'number' => 4,
            'startDate' => '21.07',
            'endDate' => '27.07'
        ],
        'Молодые ученые и преподаватели экономических наук' => [
            'number' => 5,
            'startDate' => '29.07',
            'endDate' => '04.08'
        ],
        'Молодые ученые и преподаватели в области здравоохранения' => [
            'number' => 6,
            'startDate' => '06.08',
            'endDate' => '12.08'
        ],
        'Молодые руководители социальных НКО и проектов' => [
            'number' => 7,
            'startDate' => '14.08',
            'endDate' => '20.08'
        ],
        'Молодые преподаватели факультетов журналистики, молодые журналисты' => [
            'number' => 8,
            'startDate' => '22.08',
            'endDate' => '28.08'
        ],
        '№1. Заезд (смены: Молодые ученые и преподаватели общественных наук; Молодые депутаты и политические лидеры; Молодые ученые и преподаватели в области IT-технологии; Молодые специалисты в области межнациональных отношений)' => [
            'number' => 10,
            'startDate' => '25.06',
            'endDate' => '27.07'
        ],
        '№2. Заезд (смены: Молодые ученые и преподаватели экономических наук; Молодые ученые и преподаватели в области здравоохранения; Молодые руководители социальных НКО и проектов; Молодые преподаватели факультетов журналистики, молодые журналисты)' => [
            'number' => 10,
            'startDate' => '27.07',
            'endDate' => '28.08'
        ],
    ];

    public function actionNotifyAis()
    {
        $rows = \Yii::app()->getDb()->createCommand()
            ->select('DISTINCT b."UserId", SUBSTRING(d."Attributes"::TEXT FROM \'"ais_registration_id":"(\d+)"\') AS "RegistrationId"')
            ->from('RuventsBadge b')
            ->join('EventUserData d', 'd."EventId" = b."EventId" AND d."UserId" = b."UserId"')
            ->where('b."EventId" = :eventId AND d."Attributes"::TEXT ~ \'"ais_registration_id":"\d+"\'', [
                ':eventId' => Event::TS16
            ])
            ->query();

        $ais = new AIS();
        foreach ($rows as $row) {
            if ($ais->notify($row['RegistrationId'])) {
                $this->info("Success send information regID: {$row['RegistrationId']}");
            } else {
                $this->error("Error while processing regID: {$row['RegistrationId']}");
            }
        }
    }


    /**
     * Imports participants from the AIS system
     *
     * @param bool $update Update the information for the last day
     */
    public function actionImportParticipantsFromAIS($update = false, $drain = false)
    {
        $ais = new AIS();

        $yesterday = $update ? (new DateTime())->sub(new DateInterval('PT15M'))->format('Y-m-d H:i:s') : null;


        // Find the TS event
        $event = Event::model()->findByPk(Event::TS16);
        // Disable participants notification
        $event->skipOnRegister = true;
        $rolesMap = [
            self::AIS_VOLUNTEERS_EVENT_ID => Role::model()->findByPk(Role::VOLUNTEER),
            self::AIS_PARTICIPANTS_EVENT_ID => Role::model()->findByPk(Role::PARTICIPANT)
        ];

        if (!$apiAccount = Account::model()->byEventId(Event::TS16)->find()) {
            echo "API account for the event has not beed found\n";
            return;
        }

        $total = 0;

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            foreach ($rolesMap as $aisEventId => $role) {
                foreach ($ais->fetchRegistrations($aisEventId, $yesterday) as $reg) {
                    if ($drain) {
                        continue;
                    }
                    if ($reg['status'] < 12 /* 12 or 13 */) {
                        continue;
                    }

                    $user = $this->processRegistration($reg, $event, $role, $apiAccount);

                    $this->info("#$total: User {$user->getFullName()} is successfully registered for the event {$event->IdName}");

                    $total++;
                }
            }

            $transaction->commit();

            $this->log("Total count of users that have been registered: $total.");
        } catch (\CDbException $e) {
            $transaction->rollback();
            echo $e->getMessage() . "\n";
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
        if (!$user = $this->fetchUser($data['email'], $data['firstname'], $data['surname'], $data['pathname'])) {
            return null;
        }

        $user->refreshUpdateTime();

        $userId = $data['user_id'];
        $region = $data['socr'] . ' ' . $data['region_name'];
        $country = $data['country_name'] ?: 'Россия';
        $smena = $data['smena_nm'];
        $team = $data['twenty'];
        $registrationId = $data['registration_id'];

        $photoUrl = AIS::getAvatarUrl($userId);
        if ($this->urlExists($photoUrl) && !$user->getPhoto()->hasImage()) {
            $user->getPhoto()->save($photoUrl);
        }

        $event->registerUser($user, $role);

        $data = UserData::fetch($event, $user);

        if (!$externalUser = ExternalUser::model()->byAccountId($apiAccount->Id)->byUserId($user->Id)->find()) {
            ExternalUser::create($user, $apiAccount, $userId);
        } else {
            $externalUser->ExternalId = $userId;
            $externalUser->save();
        }

        $m = $data->getManager();
        $m->country = $country;
        $m->region = $region;
        list($m->start_date, $m->end_date, $m->smena_no) = $this->detectShiftDates($smena);
        $m->smena = $smena;
        $m->ais_registration_id = $registrationId;
        $m->team_number = $team;

        $data->save();

        return $user;
    }

    /**
     * Fetches or create the user
     *
     * @param string $email The user email
     * @param string $firstName First name
     * @param string $lastName Last name
     * @param string $fatherName Father name
     * @return User|null Created or fetched user
     */
    private function fetchUser($email, $firstName, $lastName, $fatherName)
    {
        if (!$user = User::model()->byTemporary(false)->byEmail($email)->find()) {
            if (!$user = User::create($email, $firstName, $lastName, $fatherName, false)) {
                $this->error('#$total: Unable to create a user');
                return null;
            } else {
                if (!$user->LastName) {
                    $user->LastName = $lastName;
                }

                if (!$user->FirstName) {
                    $user->FirstName = $firstName;
                }

                if (!$user->FatherName) {
                    $user->FatherName = $fatherName;
                }

                $user->save();
            }

            $user->refresh();
            $user->Settings->UnsubscribeAll = true;
            $user->Settings->save();

            $this->info("User {$user->getFullName()} has been registered");
        } else {
            $this->info("User {$user->getFullName()} has been found");
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

    /**
     * Checks that the url exists
     *
     * @param string $url
     * @return bool
     */
    private function urlExists($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        $good = curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200;
        curl_close($ch);

        return $good;
    }
}
