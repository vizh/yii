<?php

class m161011_231720_user_trim extends CDbMigration
{
    public function up()
    {
        $this->execute('UPDATE "User" SET
            "FirstName" = trim("FirstName"),
            "LastName" = trim("LastName"),
            "FatherName" = trim("FatherName")
        ');
    }
}