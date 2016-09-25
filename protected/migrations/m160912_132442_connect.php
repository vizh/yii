<?php

class m160912_132442_connect extends CDbMigration
{
	public function safeUp()
	{
        $this->createTable('EventMeetingPlace', [
            'Id' => 'serial PRIMARY KEY',
            'EventId' => 'integer not null',
            'Name' => 'varchar(255) not null'
        ]);
        $this->addForeignKey('fk_EventMeetingPlace_Event', 'EventMeetingPlace', 'EventId', 'Event', 'Id', 'cascade', 'cascade');

	    $this->createTable('ConnectMeeting', [
	        'Id' => 'serial PRIMARY KEY',
            'CreatorId' => 'integer not null',
            'PlaceId' => 'integer not null',
            'Date' => 'timestamp without time zone',
            'UserId' => 'integer not null',
            'Status' => 'integer not null'
        ]);
        $this->addForeignKey('fk_ConnectMeeting_EventMeetingPlace', 'ConnectMeeting', 'PlaceId', 'EventMeetingPlace', 'Id', 'cascade', 'cascade');
        $this->addForeignKey('fk_ConnectMeeting_User__Creator', 'ConnectMeeting', 'CreatorId', 'User', 'Id', 'cascade', 'cascade');
        $this->addForeignKey('fk_ConnectMeeting_User__User', 'ConnectMeeting', 'UserId', 'User', 'Id', 'cascade', 'cascade');
	}

	public function safeDown()
	{
	    $this->dropTable('ConnectMeeting');
        $this->dropTable('EventMeetingPlace');
	}
}