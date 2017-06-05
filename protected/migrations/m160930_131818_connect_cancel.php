<?php

class m160930_131818_connect_cancel extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('ConnectMeeting', 'Status', 'integer not null default 1');
        $this->execute('ALTER TABLE "ConnectMeeting" ALTER COLUMN "Status" DROP DEFAULT');

        $this->addColumn('ConnectMeeting', 'CancelResponse', 'text null');
    }

    public function safeDown()
    {
        $this->dropColumn('ConnectMeeting', 'CancelResponse');

        $this->dropColumn('ConnectMeeting', 'Status');
    }
}