<?php

class m150730_160807_add_column_for_pay_cabinet_messages extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('PayAccount', 'CabinetIndexTabTitle', 'varchar(255)');
        $this->addColumn('PayAccount', 'CabinetHasRecentPaidItemsMessage', 'varchar(255)');
    }

    public function safeDown()
    {
        $this->dropColumn('PayAccount', 'CabinetIndexTabTitle');
        $this->dropColumn('PayAccount', 'CabinetHasRecentPaidItemsMessage');
    }
}