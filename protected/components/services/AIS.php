<?php
namespace application\components\services;

use GuzzleHttp;

/**
 * AIS API client
 */
class AIS
{
    const AIS_SITE = 'https://ais.fadm.gov.ru/';
    const AIS_LOGIN = 'palenov@ruvents.com';
    const AIS_PASS = 'Hfj58djw3ap';

    const URL_LOGIN = 'auth/login';
    const URL_EVENTS = 'getMyAdminEvents';
    const URL_PARTICIPANT_REGISTER = 'getUserRegistration';
    const URL_PARTICIPANT_CONFIRM_PRESENCE = 'eventChoose';
    const URL_REGISTRATIONS = 'getEventRegistrations';
    const URL_GET_AVATAR = 'users_resources/{user_id}/avatar.jpg';
    const URL_NOTIFY = 'eventChoose';

    /**
     * @var GuzzleHttp\Client
     */
    private $guzzle;

    /**
     * Returns shifts names
     * 
     * @return string[]
     */
    public static function getShifts()
    {
        return [
            'Молодые ученые и преподаватели общественных наук',
            'Молодые депутаты и политические лидеры',
            'Молодые ученые и преподаватели в области IT-технологий',
            'Молодые специалисты в области межнациональных отношений',
            'Молодые ученые и преподаватели экономических наук',
            'Молодые ученые и преподаватели в области здравоохранения',
            'Молодые руководители социальных НКО и проектов',
            'Молодые преподаватели факультетов журналистики, молодые журналисты'
        ];
    }
    
    /**
     * Returns an url for getting the avatar of the user
     *
     * @param int $userId
     * @return string
     */
    public static function getAvatarUrl($userId)
    {
        return self::AIS_SITE . strtr(self::URL_GET_AVATAR, ['{user_id}' => $userId]);
    }

    /**
     * Construct the object
     */
    public function __construct()
    {
        $this->guzzle= new GuzzleHttp\Client([
            'cookies' => true
        ]);
    }

    /**
     * Returns list of events
     */
    public function fetchEvents()
    {
        $this->auth();

        $res = $this->guzzle->get(self::AIS_SITE . self::URL_EVENTS);

        return json_decode((string) $res->getBody(), true);
    }

    /**
     * Returns registrations
     *
     * @param int $eventId Event identifier
     * @param string $dateTime Date and/or time as a start time for fetching registrations
     * @return array
     * @throws \CException
     */
    public function fetchRegistrations($eventId, $dateTime = null)
    {
        $this->auth();

        $params = [
            'event_id' => $eventId
        ];

        if ($dateTime) {
            $params['date'] = $dateTime;
        }

        $url = self::AIS_SITE . self::URL_REGISTRATIONS . '?' . http_build_query($params, null, '&');

        $res = $this->guzzle->get($url, [
            'cookies' => true
        ]);

        return json_decode((string) $res->getBody(), true);
    }

    /**
     * Notifies AIS about coming
     *
     * @param int $registrationId
     * @throws \CException
     */
    public function notify($registrationId)
    {
        $this->auth();

        $this->guzzle->post(self::AIS_SITE . self::URL_NOTIFY, [
            'body' => [
                'action' => 'was',
                'registration' => $registrationId
            ]
        ]);
    }

    /**
     * Authenticate the client
     *
     * @throws \CException
     */
    private function auth()
    {
        $res = $this->guzzle->post(self::AIS_SITE . self::URL_LOGIN, [
            'body' => [
                'email' => self::AIS_LOGIN,
                'password' => self::AIS_PASS,
                'remember' => '1'
            ],
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept-Encoding' => 'application/json'
            ],
            'cookies' => true
        ]);

        if ($res->getStatusCode() !== 200) {
            throw new \CException('Unable to authenticate at AIS');
        }
    }
}