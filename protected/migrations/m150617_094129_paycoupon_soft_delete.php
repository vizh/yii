<?php

class m150617_094129_paycoupon_soft_delete extends CDbMigration
{
    /*
	public function up()
	{
	}

	public function down()
	{
		echo "m150617_094129_paycoupon_soft_delete does not support migration down.\n";
		return false;
	}*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('PayCoupon', 'Deleted', 'boolean DEFAULT false');
        $this->addColumn('PayCoupon', 'DeletionTime', 'timestamp NULL DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('PayCoupon', 'Deleted');
        $this->dropColumn('PayCoupon', 'DeletionTime');
    }
}