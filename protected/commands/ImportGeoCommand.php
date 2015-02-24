<?php

use application\components\utility\Texts;
use application\helpers\VKAPI;
use education\models\Faculty;
use education\models\University;
use geo2\models\City;
use geo2\models\Country;
use geo2\models\Region;

\Yii::import('application.helpers.VKAPI', true);
\Yii::import('application.modules.geo.models.import.*', true);

class ImportGeoCommand extends CConsoleCommand
{
    const COUNTRY_TABLE_NAME = 'Geo2Country';
    const REGION_TABLE_NAME = 'Geo2Region';
    const CITY_TABLE_NAME = 'Geo2City';

    const UNIVERSITY_TABLE_NAME = 'EducationUniversity';
    const FACULTY_TABLE_NAME = 'EducationFaculty';

    public $defaultAction='base';

//    public function run($args)
//    {
//        $response = VKAPI::databaseGetCities(1, 1000001, 1000, 0, 0);
//        print_r($response);
//        return;
//
//
//
//        $this->clearDb();
//
//        $this->importCountries();
//        $this->importRegions();
//
//        echo 0;
//        return;
//
//        throw new \CException('Закоменнтируйте вызов исключения для импорта.');
//
//
//        echo 'Import Cities...';
//        $this->importCities();
//
//        \Yii::app()->db->createCommand()->delete('GeoCity');
//        \Yii::app()->db->createCommand()->delete('GeoRegion');
//        \Yii::app()->db->createCommand()->delete('GeoCountry');
//
//        \Yii::app()->db->createCommand('INSERT INTO "GeoCountry" SELECT "Id", "Name" FROM "' . self::COUNTRY_TABLE_NAME . '"')->execute();
//        \Yii::app()->db->createCommand('INSERT INTO "GeoRegion" SELECT "Id", "CountryId", "Name", "Name"::tsvector FROM "' . self::REGION_TABLE_NAME . '"')->execute();
//        \Yii::app()->db->createCommand('INSERT INTO "GeoCity" SELECT "Id", "RegionId", "CountryId", "Name", "Name"::tsvector, "Priority" FROM "' . self::CITY_TABLE_NAME . '"')->execute();
//    }

    public function actionBase()
    {
        echo "already imported\r\n";
        exit(0);

//        $this->clearDb();
//
//        $this->importCountries();
//        $this->importRegions();
    }

    public function actionCitiesByCountry()
    {
        echo "already imported\r\n";
        exit(0);

        while (true) {
            $transaction = Yii::app()->getDb()->beginTransaction();
            $criteria = new CDbCriteria();
            $criteria->addCondition('NOT t."CitiesParsed"');
            $country = Country::model()->find($criteria);
            if ($country === null) {
                echo "\r\n\r\nDone!\r\n";
                exit(0);
            }
            try {
                echo "Start:" . $country->Id . "\t";
                $this->importCitiesByCountry($country);
                echo "End \r\n";
                $country->CitiesParsed = true;
                $country->save();
                $transaction->commit();
            } catch (Exception $e) {
                echo "Error: {$e->getMessage()} \r\n";
                $transaction->rollback();
            }
        }
    }

    public function actionCitiesByRegion()
    {
        echo "already imported\r\n";
        exit(0);

        while (true) {
            $region = null;
            $result = false;
            $transaction = Yii::app()->getDb()->beginTransaction();
            $sql = 'SELECT "Id" FROM "Geo2Region"
WHERE NOT "CitiesParsed" AND NOT "Error" AND NOT "Start" LIMIT 1
FOR UPDATE';
            $result = \Yii::app()->getDb()->createCommand($sql)->queryRow();
            if ($result !== false) {
                \Yii::app()->getDb()->createCommand('UPDATE "Geo2Region" SET "Start" = \'t\' WHERE "Id" = :Id')->execute(['Id' => $result['Id']]);
            }
            $transaction->commit();

            $transaction = Yii::app()->getDb()->beginTransaction();
            if ($result !== false) {
                $region = Region::model()->findByPk($result['Id']);
            }
            if ($region === null) {
                echo "\r\n\r\nDone!\r\n";
                exit(0);
            }
            try {
                echo "Start:" . $region->Id . "\t";
                $this->importCitiesByRegion($region);
                echo "End \r\n";
                $region->CitiesParsed = true;
                $region->save();
                $transaction->commit();
            } catch (Exception $e) {
                echo "Error: {$e->getMessage()} \r\n";
                $transaction->rollback();
                $region->Error = true;
                $region->save();
            }
        }
    }

    public function actionUniversities()
    {
        echo "already imported\r\n";
        exit(0);

        while (true) {
            $transaction = Yii::app()->getDb()->beginTransaction();
            $criteria = new CDbCriteria();
            $criteria->addCondition('NOT t."Parsed" AND ("CountryId" = 160 AND "Area" IS NULL OR "RegionId" IS NULL)');
            $criteria->limit = 1;
            $city = City::model()->find($criteria);
            if ($city === null) {
                echo "\r\n\r\nDone!\r\n";
                exit(0);
            }
            try {
                echo "Start:" . $city->Id . "\t";
                $this->importUniversities($city);
                echo "End \r\n";
                $city->Parsed = true;
                $city->save();
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                echo "Error: {$e->getMessage()} \r\n";
                exit(1);
            }
        }
    }

    public function actionFaculties()
    {
        echo "already imported\r\n";
        exit(0);

        while (true) {
            $university = null;
            $result = false;
            $transaction = Yii::app()->getDb()->beginTransaction();
            $sql = 'SELECT "Id" FROM "EducationUniversity"
WHERE NOT "Parsed" AND NOT "Start" LIMIT 1
FOR UPDATE';
            $result = \Yii::app()->getDb()->createCommand($sql)->queryRow();
            if ($result !== false) {
                \Yii::app()->getDb()->createCommand('UPDATE "EducationUniversity" SET "Start" = \'t\' WHERE "Id" = :Id')->execute(['Id' => $result['Id']]);
            }
            $transaction->commit();

            $transaction = Yii::app()->getDb()->beginTransaction();
            if ($result !== false) {
                $university = University::model()->findByPk($result['Id']);
            }
            if ($university === null) {
                echo "\r\n\r\nDone!\r\n";
                exit(0);
            }
            try {
                echo "Start:" . $university->Id . "\t";
                $this->importFaculties($university);
                echo "End \r\n";
                $university->Parsed = true;
                $university->save();
                $transaction->commit();
            } catch (Exception $e) {
                echo "Error: {$e->getMessage()} \r\n";
                $transaction->rollback();
                exit(1);
            }
        }
    }

    protected function clearDb()
    {
        \Yii::app()->getDb()->createCommand()->delete(self::CITY_TABLE_NAME);
        \Yii::app()->getDb()->createCommand()->delete(self::REGION_TABLE_NAME);
        \Yii::app()->getDb()->createCommand()->delete(self::COUNTRY_TABLE_NAME);
    }

    protected function importCountries()
    {
        $response = VKAPI::databaseGetCountries(300);
        $countries = $response['items'];

        foreach ($countries as $country) {
            \Yii::app()->getDb()->createCommand()->insert(self::COUNTRY_TABLE_NAME, [
                'ExtId' => $country['id'],
                'Name' => $country['title']
            ]);
        }
    }

    protected function importRegions()
    {
        $countries = Country::model()->findAll();

        foreach ($countries as $country) {
            echo $country->Id . "\t";
            $response = VKAPI::databaseGetRegions($country->ExtId, 1000, 0);
            $regions = $response['items'];

            if (count($regions) === 1000)
                throw new \CException('Проверить возвращаемое контактом количество регионов!');

            if (is_array($regions)) {
                foreach ($regions as $region) {
                    \Yii::app()->getDb()->createCommand()->insert(self::REGION_TABLE_NAME, [
                        'Name' => $region['title'],
                        'CountryId' => $country->Id,
                        'ExtId' => $region['id']
                    ]);
                }
            } else {
                echo "Empty array: \r\n";
                print_r($response);
            }

            echo "\r\n";
        }

        echo "Successful!\r\n";
    }

    protected function importCitiesByCountry(Country $country)
    {
        $response = VKAPI::databaseGetCities($country->ExtId, null, 1000, 0, 0);
        $cities = $response['items'];

        foreach ($cities as $city) {
            \Yii::app()->getDb()->createCommand()->insert(self::CITY_TABLE_NAME, [
                'ExtId' => $city['id'],
                'Name' => $city['title'],
                'CountryId' => $country->Id,
                'Priority' => 100
            ]);
        }
    }

    protected function importCitiesByRegion(Region $region)
    {
        for (
            $offset = 0;
            $response = VKAPI::databaseGetCities($region->Country->ExtId, $region->ExtId, 1000, $offset),
            !empty($response['items']);
            $offset += 1000
        ) {
            if ($offset > 0)
                echo "\n\nOffset: " . $offset . "\n";

            $cities = $response['items'];
            foreach ($cities as $city) {
                \Yii::app()->getDb()->createCommand()->insert(self::CITY_TABLE_NAME, [
                    'ExtId' => $city['id'],
                    'Name' => $city['title'],
                    'CountryId' => $region->Country->Id,
                    'RegionId' => $region->Id,
                    'Area' => !empty($city['area']) ? $city['area'] : null
                ]);
            }
        }
    }

    protected function importUniversities(City $city)
    {
        $response = VKAPI::databaseGetUniversities($city->Country->ExtId, $city->ExtId, 1000, 0, 0);
        $universities = $response['items'];

        foreach ($universities as $university) {
            \Yii::app()->getDb()->createCommand()->insert(self::UNIVERSITY_TABLE_NAME, [
                'ExtId' => $university['id'],
                'Name' => $university['title'],
                'CityId' => $city->Id
            ]);
        }
    }

    protected function importFaculties(University $university)
    {
        $response = VKAPI::databaseGetFaculties($university->ExtId, 1000, 0);
        $faculties = $response['items'];

        foreach ($faculties as $faculty) {
            \Yii::app()->getDb()->createCommand()->insert(self::FACULTY_TABLE_NAME, [
                'ExtId' => $faculty['id'],
                'Name' => $faculty['title'],
                'UniversityId' => $university->Id
            ]);
        }
    }
}