<?php

class m170717_063833_event_rename_fields extends CDbMigration
{
	public function up()
	{
	    $this->renameColumn('Event', 'ShowOnMain', 'VisibleOnMain');
	}

	public function down()
	{
        $this->renameColumn('Event', 'VisibleOnMain', 'ShowOnMain');
	}
}