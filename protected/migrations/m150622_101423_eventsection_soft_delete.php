<?php

class m150622_101423_eventsection_soft_delete extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('EventSection', 'DeletionTime', 'timestamp NULL DEFAULT NULL');
        $this->addColumn('EventSectionHall', 'DeletionTime', 'timestamp NULL DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('EventSection', 'DeletionTime');
        $this->dropColumn('EventSectionHall', 'DeletionTime');
    }
}