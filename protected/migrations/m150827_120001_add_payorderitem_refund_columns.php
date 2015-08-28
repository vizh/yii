<?php

class m150827_120001_add_payorderitem_refund_columns extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('PayOrderItem', 'Refund', 'boolean DEFAULT false');
        $this->addColumn('PayOrderItem', 'RefundTime', 'timestamp NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('PayOrderItem', 'Refund');
        $this->dropColumn('PayOrderItem', 'RefundTime');
    }
}