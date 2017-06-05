<?php

class m150827_074750_add_eventrole_notification_column extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('EventRole', 'Notification', 'boolean DEFAULT true');
        $this->update('EventRole', ['Notification' => 'false'], '"Id" = 24');
    }

    public function safeDown()
    {
        $this->dropColumn('EventRole', 'Notification');
    }
}