<?php

class m161202_141033_order_system extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('PayOrder', 'System', 'varchar(255) null');
        $this->execute('UPDATE "PayOrder" SET "System" = (
            SELECT \'paypal\' FROM "PayLog" WHERE "OrderId" = "PayOrder"."Id" AND NOT "Error" AND "PaySystem" = \'pay\components\systems\PayPal\'
        );');
    }

    public function safeDown()
    {
        $this->dropColumn('PayOrder', 'System');
    }
}