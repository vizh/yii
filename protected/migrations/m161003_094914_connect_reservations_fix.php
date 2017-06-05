<?php

class m161003_094914_connect_reservations_fix extends CDbMigration
{
    public function safeUp()
    {
        $this->dropColumn('EventMeetingPlace', 'ReservationLimit');
        $this->dropColumn('ConnectMeeting', 'ReservationNumber');
    }

    public function safeDown()
    {
        $this->addColumn('EventMeetingPlace', 'ReservationLimit', 'integer null');
        $this->addColumn('ConnectMeeting', 'ReservationNumber', 'integer null');
    }
}