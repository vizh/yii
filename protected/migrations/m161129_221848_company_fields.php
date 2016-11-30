<?php

class m161129_221848_company_fields extends CDbMigration
{
	public function safeUp()
	{
	    $this->addColumn('Company', 'OGRN', 'string null');
	}

	public function safeDown()
	{
	    $this->dropColumn('Company', 'OGRN');
	}
}