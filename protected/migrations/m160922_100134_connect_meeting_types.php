<?php

class m160922_100134_connect_meeting_types extends CDbMigration
{
    public function safeUp()
    {
        $this->delete('ConnectMeeting');
        $this->delete('EventMeetingPlace');

        $this->createTable('ConnectMeetingLinkUser', [
            'Id' => 'serial primary key',
            'MeetingId' => 'integer not null',
            'UserId' => 'integer not null',
            'Status' => 'integer not null',
            'Response' => 'text null',
        ]);
        $this->addForeignKey('ConnectMeetingLinkUser_MeetingId_fkey', 'ConnectMeetingLinkUser', 'MeetingId', 'ConnectMeeting', 'Id', 'cascade', 'cascade');
        $this->addForeignKey('ConnectMeetingLinkUser_UserId_fkey', 'ConnectMeetingLinkUser', 'UserId', 'User', 'Id', 'cascade', 'cascade');

        $this->dropForeignKey('fk_ConnectMeeting_User__User', 'ConnectMeeting');
        $this->dropColumn('ConnectMeeting', 'UserId');
        $this->dropColumn('ConnectMeeting', 'Status');
        $this->addColumn('ConnectMeeting', 'Type', 'integer not null');
        $this->addColumn('ConnectMeeting', 'Purpose', 'varchar(255) null');
        $this->addColumn('ConnectMeeting', 'Subject', 'varchar(255) null');
        $this->addColumn('ConnectMeeting', 'File', 'varchar(255) null');

        $this->addColumn('EventMeetingPlace', 'Reservation', 'boolean not null');
        $this->addColumn('EventMeetingPlace', 'ReservationTime', 'integer null');
        $this->addColumn('EventMeetingPlace', 'ReservationLimit', 'integer null');
        $this->addColumn('ConnectMeeting', 'CreateTime', 'timestamp without time zone');
        $this->addColumn('ConnectMeeting', 'ReservationNumber', 'integer null');
    }

    public function safeDown()
    {
        $this->delete('ConnectMeeting');
        $this->delete('EventMeetingPlace');

        $this->dropColumn('ConnectMeeting', 'ReservationNumber');
        $this->dropColumn('ConnectMeeting', 'CreateTime');
        $this->dropColumn('EventMeetingPlace', 'ReservationLimit');
        $this->dropColumn('EventMeetingPlace', 'ReservationTime');
        $this->dropColumn('EventMeetingPlace', 'Reservation');

        $this->dropColumn('ConnectMeeting', 'File');
        $this->dropColumn('ConnectMeeting', 'Subject');
        $this->dropColumn('ConnectMeeting', 'Purpose');
        $this->dropColumn('ConnectMeeting', 'Type');
        $this->addColumn('ConnectMeeting', 'UserId', 'integer not null');
        $this->addColumn('ConnectMeeting', 'Status', 'integer not null');
        $this->addForeignKey('fk_ConnectMeeting_User__User', 'ConnectMeeting', 'UserId', 'User', 'Id', 'cascade', 'cascade');

        $this->dropTable('ConnectMeetingLinkUser');
    }
}