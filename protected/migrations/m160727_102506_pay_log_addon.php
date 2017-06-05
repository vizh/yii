<?php

class m160727_102506_pay_log_addon extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('PayLog', 'NotificationSent', 'boolean default false');
        $this->createIndex('idx_pl_ns', 'PayLog', 'NotificationSent, Error');
        $this->update('PayLog', ['NotificationSent' => true]);
    }

    public function safeDown()
    {
        $this->dropColumn('PayLog', 'NotificationSent');
    }

}