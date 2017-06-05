<?php

class m150902_144105_add_column_user_verified extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('User', 'Verified', 'boolean DEFAULT false NOT NULL');
        $this->addColumn('MailTemplate', 'SendUnverified', 'boolean DEFAULT false NOT NULL');
        $this->execute('UPDATE "User" SET "Verified" = \'t\' WHERE NOT "Temporary" AND "Visible"');
    }

    public function safeDown()
    {
        $this->dropColumn('User', 'Verified');
        $this->dropColumn('MailTemplate', 'SendUnverified');
    }
}