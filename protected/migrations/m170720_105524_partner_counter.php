<?php

class m170720_105524_partner_counter extends CDbMigration
{
	public function safeUp()
	{
	    $this->addColumn('Event', 'CounterHTML', 'text');
	}

	public function safeDown()
	{
	    $this->dropColumn('Event', 'CounterHTML');
	}
}