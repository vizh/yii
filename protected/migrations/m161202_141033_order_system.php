<?php

class m161202_141033_order_system extends CDbMigration
{
	public function safeUp()
	{
	    $this->addColumn('PayOrder', 'System', 'varchar(255) null');
	    $this->execute('update "PayOrder" set "System" = (
            select \'paypal\' from "PayLog" where "OrderId" = "PayOrder"."Id" and not "Error" and "PaySystem" = \'pay\components\systems\PayPal\'
        );');
	}

	public function safeDown()
	{
	    $this->dropColumn('PayOrder', 'System');
	}
}