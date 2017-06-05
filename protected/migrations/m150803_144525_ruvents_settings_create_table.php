<?php

class m150803_144525_ruvents_settings_create_table extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute('DROP TABLE IF EXISTS "RuventsSetting"');
        $this->createTable('RuventsSetting', [
            'Id' => 'serial PRIMARY KEY',
            'EventId' => 'integer NOT NULL',
            'Attributes' => 'json NOT NULL',
        ]);
        $this->addForeignKey('RuventsSetting_EventId_fkey', 'RuventsSetting', 'EventId', 'Event', 'Id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropIndex('RuventsSetting_EventId_fkey', 'RuventsSetting');
        $this->dropTable('RuventsSetting');
    }
}