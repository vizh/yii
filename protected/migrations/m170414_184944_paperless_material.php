<?php

class m170414_184944_paperless_material extends CDbMigration
{
    public function up()
    {
        $this->dropColumn('PaperlessEvent', 'FromName');
        $this->dropColumn('PaperlessEvent', 'FromAddress');
    }

    public function down()
    {
        $this->addColumn('PaperlessEvent', 'FromName', 'string');
        $this->addColumn('PaperlessEvent', 'FromAddress', 'string');
    }
}