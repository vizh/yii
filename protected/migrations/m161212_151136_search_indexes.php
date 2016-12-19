<?php

class m161212_151136_search_indexes extends CDbMigration
{
	public function safeUp()
	{
	    $this->execute('create index "Translation_idx" on "Translation" using gin ("Value" gin_trgm_ops);');
        $this->execute('create index "User_LastName_trgm" on "User" using gin ("LastName" gin_trgm_ops);');
        $this->execute('create index "User_FirstName_trgm" on "User" using gin ("FirstName" gin_trgm_ops);');
        $this->execute('create index "User_FatherName_trgm" on "User" using gin ("FatherName" gin_trgm_ops);');
        $this->execute('create index "Company_Name_trgm" on "Company" using gin ("Name" gin_trgm_ops);');
	}

	public function safeDown()
	{
	    $this->dropIndex('Translation_idx', 'Translation');
        $this->dropIndex('User_LastName_trgm', 'User');
        $this->dropIndex('User_FirstName_trgm', 'User');
        $this->dropIndex('User_FatherName_trgm', 'User');
        $this->dropIndex('Company_Name_trgm', 'Company');
	}
}