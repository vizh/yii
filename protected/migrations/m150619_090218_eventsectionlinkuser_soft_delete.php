<?php

class m150619_090218_eventsectionlinkuser_soft_delete extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('EventSectionLinkUser', 'DeletionTime', 'timestamp NULL DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('EventSectionLinkUser', 'DeletionTime');
    }
}