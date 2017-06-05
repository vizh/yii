<?php

class m150210_160741_create_new_geo_and_universities_structure extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('Geo2Country', [
            'Id' => 'serial PRIMARY KEY',
            'ExtId' => 'integer NOT NULL',
            'Name' => 'varchar(255) NOT NULL',
            'Priority' => 'integer NOT NULL DEFAULT 0'
        ]);

        $this->createTable('Geo2Region', [
            'Id' => 'serial PRIMARY KEY',
            'ExtId' => 'integer NOT NULL',
            'CountryId' => 'integer NOT NULL',
            'Name' => 'varchar(255) NOT NULL',
            'Priority' => 'integer NOT NULL DEFAULT 0'
        ]);
        $this->execute('CREATE INDEX "Geo2Region_CountryId_idx" ON "Geo2Region" USING BTREE("CountryId")');
        $this->addForeignKey('Geo2Region_CountryId_fkey', 'Geo2Region', 'CountryId', 'Geo2Country', 'Id', 'RESTRICT', 'RESTRICT');

        $this->createTable('Geo2City', [
            'Id' => 'serial PRIMARY KEY',
            'ExtId' => 'integer NOT NULL',
            'CountryId' => 'integer NOT NULL',
            'RegionId' => 'integer',
            'Name' => 'varchar(255) NOT NULL',
            'SearchName' => 'tsvector NOT NULL',
            'Area' => 'varchar(255)',
            'Priority' => 'integer NOT NULL DEFAULT 0'
        ]);
        $this->execute('CREATE INDEX "Geo2City_CountryId_idx" ON "Geo2City" USING BTREE("CountryId")');
        $this->execute('CREATE INDEX "Geo2City_RegionId_idx" ON "Geo2City" USING BTREE("RegionId")');
        $this->execute('CREATE INDEX "Geo2City_Name_idx" ON "Geo2City" USING BTREE("Name")');
        $this->execute('CREATE INDEX "Geo2City_SearchName_idx" ON "Geo2City" USING GIN("SearchName")');
        $this->addForeignKey('Geo2City_CountryId_fkey', 'Geo2City', 'CountryId', 'Geo2Country', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('Geo2City_RegionId_fkey', 'Geo2City', 'RegionId', 'Geo2Region', 'Id', 'RESTRICT', 'RESTRICT');

        $this->createTable('EducationUniversity', [
            'Id' => 'serial PRIMARY KEY',
            'ExtId' => 'integer',
            'CityId' => 'integer NOT NULL',
            'Name' => 'varchar(255) NOT NULL',
            'FullName' => 'varchar(1000)'
        ]);
        $this->execute('CREATE INDEX "EducationUniversity_CityId_idx" ON "EducationUniversity" USING BTREE("CityId")');
        $this->addForeignKey('EducationUniversity_CityId_fkey', 'EducationUniversity', 'CityId', 'Geo2City', 'Id', 'RESTRICT', 'RESTRICT');

        $this->createTable('EducationFaculty', [
            'Id' => 'serial PRIMARY KEY',
            'ExtId' => 'integer',
            'UniversityId' => 'integer NOT NULL',
            'Name' => 'varchar(255) NOT NULL'
        ]);
        $this->execute('CREATE INDEX "EducationFaculty_UniversityId_idx" ON "EducationFaculty" USING BTREE("UniversityId")');
        $this->addForeignKey('EducationFaculty_UniversityId_fkey', 'EducationFaculty', 'UniversityId', 'EducationUniversity', 'Id', 'RESTRICT', 'RESTRICT');

        // Степени высшего образования
        $this->execute("CREATE TYPE \"EducationDegree\" AS ENUM ('bachelor', 'master', 'specialist', 'candidate', 'doctor');");

        $this->createTable('UserEducation', [
            'Id' => 'serial PRIMARY KEY',
            'UserId' => 'integer NOT NULL',
            'UniversityId' => 'integer NOT NULL',
            'FacultyId' => 'integer',
            'Specialty' => 'varchar(255) NOT NULL',
            'EndYear' => 'integer',
            'Degree' => '"EducationDegree"'
        ]);
        $this->execute('CREATE INDEX "UserEducation_UserId_idx" ON "UserEducation" USING BTREE("UserId")');
        $this->addForeignKey('UserEducation_UserId_fkey', 'UserEducation', 'UserId', 'User', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('UserEducation_UniversityId_fkey', 'UserEducation', 'UniversityId', 'EducationUniversity', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('UserEducation_FacultyId_fkey', 'UserEducation', 'FacultyId', 'EducationFaculty', 'Id', 'RESTRICT', 'RESTRICT');

        return true;
    }

    public function safeDown()
    {
        $this->dropTable('UserEducation');
        $this->dropTable('EducationFaculty');
        $this->dropTable('EducationUniversity');
        $this->dropTable('Geo2City');
        $this->dropTable('Geo2Region');
        $this->dropTable('Geo2Country');

        $this->execute('DROP TYPE "EducationDegree"');

        return true;
    }
}