<?php

class m150622_145105_user_merged_fields extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('User', 'MergeUserId', 'integer NULL DEFAULT NULL');
        $this->addColumn('User', 'MergeTime', 'timestamp NULL DEFAULT NULL');
        $this->addForeignKey('User_MergeUserId_fkey', 'User', 'MergeUserId', 'User', 'Id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('User_MergeUserId_fkey', 'User');
        $this->dropColumn('User', 'MergeUserId');
        $this->dropColumn('User', 'MergeTime');
    }
}