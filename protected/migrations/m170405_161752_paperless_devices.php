<?php

class m170405_161752_paperless_devices extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('PaperlessDevice', [
            'Id' => 'string not null',
            'EventId' => 'integer not null',
            'Name' => 'string',
            'Type' => 'string',
            'Comment' => 'text',
            'Active' => 'boolean'
        ]);
        $this->addPrimaryKey('pk_PaperlessDevice', 'PaperlessDevice', 'Id');
        $this->addForeignKey('fk_PaperlessDevice_Event', 'PaperlessDevice', 'EventId', 'Event', 'Id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropTable('PaperlessDevice');
    }
}