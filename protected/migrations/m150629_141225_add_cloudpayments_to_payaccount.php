<?php

class m150629_141225_add_cloudpayments_to_payaccount extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('PayAccount', 'CloudPayments', 'bool DEFAULT false');
    }

    public function safeDown()
    {
        $this->dropColumn('PayAccount', 'CloudPayments');
    }
}