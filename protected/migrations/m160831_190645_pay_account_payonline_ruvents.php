<?php

class m160831_190645_pay_account_payonline_ruvents extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('PayAccount', 'PayOnlineRuvents', 'boolean DEFAULT false');
    }

    public function safeDown()
    {
        // Не можем откатывать миграции, опубликованные в production
        return false;
    }
}