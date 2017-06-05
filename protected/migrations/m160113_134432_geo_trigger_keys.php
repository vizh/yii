<?php

class m160113_134432_geo_trigger_keys extends CDbMigration
{
    public function safeUp()
    {

        $this->dropTable('GeoCountry');
        $this->dropTable('GeoRegion');
        $this->dropTable('GeoCity');

        $this->renameTable('Geo2Country', 'GeoCountry');
        $this->renameTable('Geo2Region', 'GeoRegion');
        $this->renameTable('Geo2City', 'GeoCity');

        $this->execute('
            CREATE FUNCTION "IncrementGeoCityPriority"() RETURNS TRIGGER AS $GeoCity$
                BEGIN
                	IF NEW."CityId" IS NOT NULL THEN
                		UPDATE "GeoCity" SET "Priority" = "Priority" + 1 WHERE "Id" = NEW."CityId";
					END IF;
                    RETURN NEW;
                END;
            $GeoCity$ LANGUAGE plpgsql;
        ');

        $this->execute('
            CREATE TRIGGER "IncrementGeoCityPriority"
            AFTER INSERT OR UPDATE ON "public"."ContactAddress"
            FOR EACH ROW
            EXECUTE PROCEDURE "IncrementGeoCityPriority"();
        ');

        $this->execute('
            CREATE TRIGGER "IncrementGeoCityPriority"
            AFTER INSERT OR UPDATE ON "public"."EducationUniversity"
            FOR EACH ROW
            EXECUTE PROCEDURE "IncrementGeoCityPriority"();
        ');

        $this->addColumn('GeoRegion', 'SearchName', 'tsvector');
        $this->execute('CREATE INDEX "GeoRegion_SearchName_idx" ON "GeoRegion" USING GIN("SearchName")');

        $command = \Yii::app()->getDb()->createCommand();
        $command->from('GeoRegion');
        $command->order = 'Id ASC';
        $regions = $command->queryAll();

        foreach ($regions as $region) {
            $result = [];
            foreach (explode(' ', $region['Name']) as $part) {
                $part = preg_replace('/\W+/u', '', $part);
                $part = trim($part);
                if (!empty($part)) {
                    $result[] = $part;
                }
            }
            $this->update('GeoRegion', [
                'SearchName' => new \CDbExpression('to_tsvector(\''.implode(' ', $result).'\')'),
            ], '"Id" = '.$region['Id']);
        }

        $this->addForeignKey('ContactAddress_CountryId_fkey', 'ContactAddress', 'CountryId', 'GeoCountry', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('ContactAddress_RegionId_fkey', 'ContactAddress', 'RegionId', 'GeoRegion', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('ContactAddress_CityId_fkey', 'ContactAddress', 'CityId', 'GeoCity', 'Id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->execute('DROP TRIGGER "IncrementGeoCityPriority" ON "public"."ContactAddress"');
        $this->execute('DROP TRIGGER "IncrementGeoCityPriority" ON "public"."EducationUniversity"');
        $this->execute('DROP FUNCTION "IncrementGeoCityPriority"()');
        $this->dropColumn('GeoRegion', 'SearchName');
        $this->dropForeignKey('ContactAddress_CountryId_fkey', 'ContactAddress');
        $this->dropForeignKey('ContactAddress_RegionId_fkey', 'ContactAddress');
        $this->dropForeignKey('ContactAddress_CityId_fkey', 'ContactAddress');
    }
}