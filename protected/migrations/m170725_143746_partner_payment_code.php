<?php

class m170725_143746_partner_payment_code extends CDbMigration
{
	public function safeUp()
	{
	    $this->addColumn('Event', 'AfterPaymentHTMLCode', 'text');
	}

	public function safeDown()
	{
	    $this->dropColumn('Event', 'AfterPaymentHTMLCode');
	}
}