<?php

class m161025_171351_payonline_save extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('User', 'PayonlineRebill', 'varchar(255) null');
    }

    public function safeDown()
    {
        $this->dropColumn('User', 'PayonlineRebill');
    }
}