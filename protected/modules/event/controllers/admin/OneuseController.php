<?php

use application\components\controllers\AdminMainController;

class OneuseController extends AdminMainController
{
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
}