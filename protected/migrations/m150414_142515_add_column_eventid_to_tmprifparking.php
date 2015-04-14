<?php
class m150414_142515_add_column_eventid_to_tmprifparking extends \CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('TmpRifParking', 'EventId', 'integer');
        return true;
    }

    public function safeDown()
    {
        // Не можем откатывать миграции, опубликованные в production
        return false;
    }
}