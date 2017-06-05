<?php

class m150928_110553_payaccount_walletone extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('PayAccount', 'WalletOne', 'bool DEFAULT false');
    }

    public function safeDown()
    {
        $this->dropColumn('PayAccount', 'WalletOne');
    }
}