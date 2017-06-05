<?php

use geo\models\City;
use geo\models\Country;
use geo\models\Region;

class m160113_080640_geo2_to_geo extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        /*
        $command = \Yii::app()->getDb()->createCommand();
        $addresses = $command->from('ContactAddress')->order('Id ASC')->queryAll();
        foreach ($addresses as $address) {
            echo $address['Id'] . "\n";
            if (!empty($address['CityId'])) {
                $this->updateCity($address, $address['CityId']);
            } elseif (!empty($address['RegionId'])) {
                $this->updateRegion($address, $address['RegionId']);
            } elseif (!empty($address['CountryId'])) {
                $this->updateCountry($address, $address['CountryId']);
            }
        }*/
    }

    public function safeDown()
    {
    }

    /**
     * @param array $address
     * @param int $id
     */
    private function updateCity($address, $id)
    {
        $command = \Yii::app()->getDb()->createCommand();
        $oldCity = $command->from('GeoCity')->where('"Id" = :Id')->queryRow(true, [':Id' => $id]);
        if (empty($oldCity) || empty($oldCity['Name'])) {
            return;
        }
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."Name" = :Name');
        $criteria->params['Name'] = $oldCity['Name'];
        $city = City::model()->ordered()->find($criteria);
        if (empty($city)) {
            $city = new City();
            $city->Name = $oldCity['Name'];
            $city->RegionId = !empty($oldCity['RegionId']) ? $this->updateRegion($address, $oldCity['RegionId'])->Id : null;
            $city->CountryId = $this->updateCountry($address, $oldCity['CountryId'])->Id;
            $city->save();
        }
        $this->update('ContactAddress', [
            'CityId' => $city->Id,
            'CountryId' => $city->CountryId,
            'RegionId' => $city->RegionId
        ], '"Id" = '.$address['Id']);
    }

    /**
     * @param array $address
     * @param int $id
     * @return Region
     */
    private function updateRegion($address, $id)
    {
        $command = \Yii::app()->getDb()->createCommand();
        $oldRegion = $command->from('GeoRegion')->where('"Id" = :Id')->queryRow(true, [':Id' => $id]);
        if (empty($oldRegion)) {
            return;
        }
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."Name" = :Name');
        $criteria->params['Name'] = $oldRegion['Name'];
        $region = Region::model()->ordered()->find($criteria);
        if (empty($region)) {
            $region = new Region();
            $region->Name = $oldRegion['Name'];
            $region->CountryId = $this->updateCountry($address, $oldRegion['CountryId'])->Id;
            $region->save();
        }
        $this->update('ContactAddress', [
            'RegionId' => $region->Id,
            'CountryId' => $region->CountryId
        ], '"Id" = '.$address['Id']);
        return $region;
    }

    /**
     * @param array $address
     * @param int $id
     * @return Country
     */
    private function updateCountry($address, $id)
    {
        $command = \Yii::app()->getDb()->createCommand();
        $oldCountry = $command->from('GeoCountry')->where('"Id" = :Id')->queryRow(true, [':Id' => $id]);
        if (empty($oldCountry)) {
            return;
        }
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."Name" = :Name');
        $criteria->params['Name'] = $oldCountry['Name'];
        $country = Country::model()->ordered()->find($criteria);
        if (empty($country)) {
            $country = new Country();
            $country->Name = $oldCountry['Name'];
            $country->save();
        }
        $this->update('ContactAddress', ['CountryId' => $country->Id], '"Id" = '.$address['Id']);
        return $country;
    }
}