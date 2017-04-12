<?php

class m170412_140259_participant_badge extends CDbMigration
{
    public function up()
    {
        $this->execute(/** @lang PostgreSQL */'ALTER TABLE "EventParticipant" DISABLE TRIGGER "UpdateUser"');
        $this->addColumn('EventParticipant', 'BadgeId', 'integer null');
        $this->addColumn('EventParticipant', 'NewCreationTime', "TIMESTAMP default ('now'::text)::timestamp(0) without time zone");
        $this->addColumn('EventParticipant', 'NewUpdateTime', "TIMESTAMP default ('now'::text)::timestamp(0) without time zone");
        $this->execute(/** @lang PostgreSQL */'
            -- noinspection SqlResolve 
            UPDATE "EventParticipant" SET
              "NewCreationTime" = "CreationTime",
              "NewUpdateTime" = "UpdateTime"'
        );
        $this->dropColumn('EventParticipant', 'CreationTime');
        $this->dropColumn('EventParticipant', 'UpdateTime');
        $this->renameColumn('EventParticipant', 'NewCreationTime', 'CreationTime');
        $this->renameColumn('EventParticipant', 'NewUpdateTime', 'UpdateTime');
        $this->createIndex('EventParticipant_BadgeId_index', 'EventParticipant', 'BadgeId');
        $this->execute(/** @lang PostgreSQL */'ALTER TABLE "EventParticipant" ENABLE TRIGGER "UpdateUser"');
    }

    public function down()
    {
        $this->dropIndex('EventParticipant_BadgeId_index', 'EventParticipant');
        $this->dropColumn('EventParticipant', 'BadgeId');
    }
}