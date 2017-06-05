<?php
namespace application\helpers;

/**
 * Хелпер, позволяющий работать с API ВКонтакте
 */
class VKAPI
{
    public static $baseApiUrl = 'https://api.vk.com/method/';

    public static $CURL_OPTS = [
        CURLOPT_CONNECTTIMEOUT => 60,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_USERAGENT => 'leaderid-php',
        CURLOPT_SSL_VERIFYPEER => false
    ];

    /**
     * Возвращает список стран
     * @param int $count количество стран, которое необходимо вернуть (положительное число, по умолчанию 100, максимальное значение 1000)
     * @param int $offset отступ, необходимый для выбора определенного подмножества стран (положительное число)
     * @param int $needAll вернуть список всех стран. флаг, может принимать значения 1 или 0
     * @param string $code перечисленные через запятую двухбуквенные коды стран в стандарте ISO 3166-1 alpha-2, для которых необходимо выдать информацию.
     * @return array
     */
    public static function databaseGetCountries($count, $offset = 0, $needAll = 1, $code = null)
    {
        $opts[CURLOPT_URL] = self::$baseApiUrl.'database.getCountries';
        $params = [
            'need_all' => $needAll,
            'count' => $count,
            'offset' => $offset,
            'code' => $code
        ];
        if (is_string($code)) {
            $params = array_merge($params, ['code' => $code]);
        }

        $countries = \CJSON::decode(self::makeRequest($opts, $params));
        self::checkErrors($countries);

        return $countries['response'];
    }

    /**
     * Возвращает список регионов
     * @param int $countryId идентификатор страны, полученный методом databaseGetCountries
     * @param int $count количество стран, которое необходимо вернуть (положительное число, по умолчанию 100, максимальное значение 1000)
     * @param int $offset отступ, необходимый для выбора определенного подмножества стран (положительное число)
     * @param int $q строка поискового запроса. Например, 'Лен'
     * @return array
     */
    public static function databaseGetRegions($countryId, $count, $offset = 0, $q = null)
    {
        $opts[CURLOPT_URL] = self::$baseApiUrl.'database.getRegions';
        $params = [
            'country_id' => $countryId,
            'count' => $count,
            'offset' => $offset
        ];
        if (is_string($q)) {
            $params = array_merge($params, ['q' => $q]);
        }

        $regions = \CJSON::decode(self::makeRequest($opts, $params));
        self::checkErrors($regions);

        return $regions['response'];
    }

    /**
     * Возвращает список регионов
     * @param int $countryId идентификатор страны, полученный методом databaseGetCountries
     * @param int $regionId идентификатор региона страны, полученный методом databaseGetRegions
     * @param int $count количество стран, которое необходимо вернуть (положительное число, по умолчанию 100, максимальное значение 1000)
     * @param int $offset отступ, необходимый для выбора определенного подмножества стран (положительное число)
     * @param int $needAll вернуть список всех стран. флаг, может принимать значения 1 или 0
     * @param int $q строка поискового запроса. Например, 'Лен'
     * @return array
     */
    public static function databaseGetCities($countryId, $regionId, $count, $offset = 0, $needAll = 1, $q = null)
    {
        $opts[CURLOPT_URL] = self::$baseApiUrl.'database.getCities';
        $params = [
            'country_id' => $countryId,
            'count' => $count,
            'offset' => $offset,
            'need_all' => $needAll
        ];
        if (!empty($regionId)) {
            $params = array_merge($params, ['region_id' => $regionId]);
        }

        if (is_string($q)) {
            $params = array_merge($params, ['q' => $q]);
        }

        $cities = \CJSON::decode(self::makeRequest($opts, $params));
        self::checkErrors($cities);

        return $cities['response'];
    }

    /**
     * Возвращает список регионов
     * @param int $countryId идентификатор страны, полученный методом databaseGetCountries
     * @param int $cityId идентификатор региона страны, полученный методом databaseGetRegions
     * @param int $count количество стран, которое необходимо вернуть (положительное число, по умолчанию 100, максимальное значение 1000)
     * @param int $offset отступ, необходимый для выбора определенного подмножества стран (положительное число)
     * @param int $q строка поискового запроса. Например, 'Лен'
     * @return array
     */
    public static function databaseGetUniversities($countryId, $cityId, $count, $offset = 0, $q = null)
    {
        $opts[CURLOPT_URL] = self::$baseApiUrl.'database.getUniversities';
        $params = [
            'country_id' => $countryId,
            'city_id' => $cityId,
            'count' => $count,
            'offset' => $offset
        ];

        if (is_string($q)) {
            $params = array_merge($params, ['q' => $q]);
        }

        $universities = \CJSON::decode(self::makeRequest($opts, $params));
        self::checkErrors($universities);

        return $universities['response'];
    }

    /**
     * Возвращает список регионов
     * @param int $universityId идентификатор страны, полученный методом databaseGetCountries
     * @param int $count количество стран, которое необходимо вернуть (положительное число, по умолчанию 100, максимальное значение 1000)
     * @param int $offset отступ, необходимый для выбора определенного подмножества стран (положительное число)
     * @return array
     */
    public static function databaseGetFaculties($universityId, $count, $offset = 0)
    {
        $opts[CURLOPT_URL] = self::$baseApiUrl.'database.getFaculties';
        $params = [
            'university_id' => $universityId,
            'count' => $count,
            'offset' => $offset
        ];

        $faculties = \CJSON::decode(self::makeRequest($opts, $params));
        self::checkErrors($faculties);

        return $faculties['response'];
    }

    public static function fetchResult($decodeResult)
    {
        return [$decodeResult['response']['count'], $decodeResult['response']['items']];
    }

    /**
     * Выполняет запрос к API и возвращает результат
     * @param array $opts
     * @param array $params
     * @param bool $reExec
     * @param int $reExecCount
     * @return string
     * @throws \CException
     */
    public static function makeRequest($opts, $params, $reExec = true, $reExecCount = 10)
    {
        $params['v'] = '5.28';
        $result = '';
        do {
            $ch = curl_init();
            $exceptionTrown = false;
            try {
                $opts = \CMap::mergeArray(self::$CURL_OPTS, $opts);
                $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
                curl_setopt_array($ch, $opts);
                $result = curl_exec($ch);
                self::checkCUrlErrors($ch);
                curl_close($ch);
            } catch (\CException $e) {
                curl_close($ch);
                $exceptionTrown = true;
                if (!$reExec || $reExecCount <= 0) {
                    throw new \CException('makeRequest Error: '.$e->getMessage(), $e->getCode(), $e);
                }
            }
        } while ($exceptionTrown && $reExec && $reExecCount-- > 0);

        return $result;
    }

    /**
     * Проверяет на ошибки CUrl
     * @param int $ch
     * @throws \CHttpException
     */
    public static function checkCUrlErrors($ch)
    {
        if (($errornum = curl_errno($ch)) !== 0) {
            throw new \CHttpException(400, 'Сервис "ВКонтакте" не отвечает. Код ошибки = '.$errornum.' '.curl_error($ch));
        }
    }

    /**
     * Проверяет на ошибки ответ VK API
     * @param array $decodeResult
     * @throws \CHttpException
     */
    public static function checkErrors($decodeResult)
    {
        if (isset($decodeResult['error'])) {
            throw new \CHttpException(400, 'Error code: '.$decodeResult['error']['error_code'].' '.$decodeResult['error']['error_msg']);
        }
    }
}
