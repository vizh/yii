<?php

class m161024_144320_connect_text extends CDbMigration
{
    public function safeUp()
    {
        $this->alterColumn('ConnectMeeting', 'Purpose', 'text');
        $this->alterColumn('ConnectMeeting', 'Subject', 'text');
    }

    public function safeDown()
    {
        $this->alterColumn('ConnectMeeting', 'Purpose', 'varchar(255)');
        $this->alterColumn('ConnectMeeting', 'Subject', 'varchar(255)');
    }
}