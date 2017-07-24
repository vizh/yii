<?php

class m170721_112933_counters extends CDbMigration
{
	public function safeUp()
	{
	    $this->renameColumn('Event', 'CounterHTML', 'CounterHeadHTML');
	    $this->addColumn('Event', 'CounterBodyHTML', 'text');
	}

	public function safeDown()
	{
	    $this->dropColumn('Event', 'CounterBodyHTML');
	    $this->renameColumn('Event', 'CounterHeadHTML', 'CounterHTML');
	}
}