<?php

class m160830_061457_user_scope extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('Event', 'UserScope', 'boolean default false');
    }

    public function safeDown()
    {
        $this->dropColumn('Event', 'UserScope');
    }
}