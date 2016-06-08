<?php

use application\components\console\BaseConsoleCommand;
use application\components\services\AIS;
use event\models\Event;
use event\models\Role;
use user\models\User;
use contact\models\Address;
use geo\models\Country;
use geo\models\Region;

/**
 * Contains useful utils for events
 */
class EventCommand extends BaseConsoleCommand
{
    const AIS_EVENT_ID = 77;

    /**
     * Imports participants from the AIS system
     *
     * @param bool $update Update the information for the last day
     */
    public function actionImportParticipantsFromAIS($update = false)
    {
        $ais = new AIS();

        $yesterday = $update ? (new DateTime())->sub(new DateInterval('PT1H'))->format('Y-m-d H:i:s') : null;

        $events = $this->fetchTSEvents();
        $role = Role::model()->findByPk(Role::PARTICIPANT);

        $total = 0;

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            foreach ($ais->fetchRegistrations(self::AIS_EVENT_ID, $yesterday) as $reg) {
                if ($reg['status'] < 12 /* 12 or 13 */) {
                    continue;
                }

                if (!$user = $this->fetchUser($reg['email'], $reg['firstname'], $reg['surname'], $reg['pathname'])) {
                    continue;
                }

                $this->setUserAddress($user, $reg['country_name'] ?: 'Россия', $reg['region_name']);

                $smena = $reg['smena_nm'];
                if (!isset($events[$smena])) {
                    $this->error('#$total: Unable to find an event for the user');
                    continue;
                }

                $events[$smena]->registerUser($user, $role);

                $this->info("#$total: User {$user->getFullName()} is successfully registered for the event {$events[$smena]->IdName}");

                $total++;
            }

            $transaction->commit();

            $this->log("Total count of users that have been registered: $total.");
        } catch (\CDbException $e) {
            $transaction->rollback();
            echo $e->getMessage() . "\n";
        }
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
        if (!$user = User::model()->byEmail($email)->find()) {
            if (!$user = User::create($email, $firstName, $lastName, $fatherName, false)) {
                $this->error('#$total: Unable to create a user');
                return null;
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
     * Sets the user address
     *
     * @param User $user
     * @param string $country
     * @param string $region
     * @return bool
     */
    private function setUserAddress(User $user, $country, $region)
    {
        $country = Country::model()->find([
            'condition' => '"Name" = :name',
            'params' => [':name' => $country]
        ]);

        if (!$country) {
            return false;
        }

        $region = Region::model()->find([
            'condition' => '"Name" ILIKE :name',
            'params' => [':name' => $region.'%']
        ]);

        $address = Address::create($country, $region);
        $user->setContactAddress($address);

        return true;
    }

    /**
     * Fetches events
     *
     * @return Event[]
     * @throws \CException
     */
    private function fetchTSEvents()
    {
        $eventIds = [
            'Молодые ученые и преподаватели общественных наук' => 2766,
            'Молодые депутаты и политические лидеры' => 2767,
            'Молодые ученые и преподаватели в области IT-технологий' => 2768,
            'Молодые специалисты в области межнациональных отношений' => 2769,
            'Молодые ученые и преподаватели экономических наук' => 2770,
            'Молодые ученые и преподаватели в области здравоохранения' => 2771,
            'Молодые руководители социальных НКО и проектов' => 2772,
            'Молодые преподаватели факультетов журналистики, молодые журналисты' => 2773,
        ];

        /** @var Event[] $events */
        $events = [];
        foreach ($eventIds as $sm => $id) {
            if (!$events[$sm] = Event::model()->findByPk($id)) {
                throw new \CException('Event if not found from TS events list');
            }

            // Disable participants notification
            $events[$sm]->skipOnRegister = true;
        }

        return $events;
    }
}
