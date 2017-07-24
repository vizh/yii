<?php

class m170724_142215_api_account_comment_field extends CDbMigration
{
    public function up()
    {
        $this->addColumn('ApiAccount', 'Comment', 'text');
    }

    public function down()
    {
        $this->dropColumn('ApiAccount', 'Comment');
    }
}