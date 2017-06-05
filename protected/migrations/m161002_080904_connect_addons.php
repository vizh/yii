<?php

class m161002_080904_connect_addons extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('EventMeetingPlace', 'ParentId', 'integer null');
        $this->addForeignKey(
            'fk_EventMeetingPlace_parent',
            'EventMeetingPlace',
            'ParentId',
            'EventMeetingPlace',
            'Id'
        );
    }

    public function safeDown()
    {
        $this->dropColumn('EventMeetingPlace', 'ParentId');
    }
}