<?php

class m170415_062448_event_participant extends CDbMigration
{
    public function up()
    {
        $this->renameColumn('EventParticipant', 'BadgeId', 'BadgeUID');
    }

    public function down()
    {
        $this->renameColumn('EventParticipant', 'BadgeUID', 'BadgeId');
    }
}