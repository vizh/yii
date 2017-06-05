<?php

class m161212_151136_search_indexes extends CDbMigration
{
    public function safeUp()
    {
        $this->execute('CREATE INDEX "Translation_idx" ON "Translation" USING GIN ("Value" gin_trgm_ops);');
        $this->execute('CREATE INDEX "User_LastName_trgm" ON "User" USING GIN ("LastName" gin_trgm_ops);');
        $this->execute('CREATE INDEX "User_FirstName_trgm" ON "User" USING GIN ("FirstName" gin_trgm_ops);');
        $this->execute('CREATE INDEX "User_FatherName_trgm" ON "User" USING GIN ("FatherName" gin_trgm_ops);');
        $this->execute('CREATE INDEX "Company_Name_trgm" ON "Company" USING GIN ("Name" gin_trgm_ops);');
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