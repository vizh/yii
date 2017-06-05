<?php

class m160118_081432_remove_log extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->dropTable('ApiLog');
        $this->dropTable('MailTemplateLog');
        $this->dropTable('RuventsLog');
        $this->dropTable('SmsLog');
        $this->dropTable('UserLog');
        $this->dropTable('YiiSession');
    }

    public function safeDown()
    {
    }
}