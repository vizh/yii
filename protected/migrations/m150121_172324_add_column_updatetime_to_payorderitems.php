<?php

class m150121_172324_add_column_updatetime_to_payorderitems extends CDbMigration
{
    /*
	public function up()
	{

	}

	public function down()
	{
		echo "m150121_172324_add_column_updatetime_to_payorderitems does not support migration down.\n";
		return false;
	}
    */

	public function safeUp()
	{
        $this->addColumn('PayOrderItem', 'UpdateTime', 'timestamp NULL DEFAULT (\'now\'::text)::timestamp(0) without time zone');
        return true;
	}

	public function safeDown()
	{
        $this->dropColumn('PayOrderItem', 'UpdateTime');
        return true;
	}
}