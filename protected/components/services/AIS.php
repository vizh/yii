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

    /**
     * @var GuzzleHttp\Client
     */
    private $guzzle;

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
     * @return array
     * @throws \CException
     */
    public function fetchRegistrations($eventId)
    {
        $this->auth();

        $url = self::AIS_SITE . self::URL_REGISTRATIONS . '?' . 'event_id=' . $eventId;

        $res = $this->guzzle->get($url, [
            'cookies' => true
        ]);

        return json_decode((string) $res->getBody(), true);
    }

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