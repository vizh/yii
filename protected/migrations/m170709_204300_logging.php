<?php

class m170709_204300_logging extends CDbMigration
{
    public function up()
    {
        $this->createTable('SecurityLog', [
            'Id' => 'serial primary key',
            'UserId' => 'integer not null',
            'Model' => 'string',
            'ModelAction' => 'string',
            'Attributes' => 'json',
            'Changes' => 'jsonb',
            'CreateTime' => 'timestamptz NOT NULL DEFAULT (\'now\'::text)::timestamptz(0)'
        ]);

        $this->createIndex('SecurityLog_UserId_idx', 'SecurityLog', ['UserId']);
    }

    public function down()
    {
        $this->dropIndex('SecurityLog_UserId_idx', 'SecurityLog');
        $this->dropTable('SecurityLog');
    }
}