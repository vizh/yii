<?php

use application\extensions\behaviors\DeletableBehavior;
use application\extensions\behaviors\TimestampableBehavior;

class m160929_041725_user_devices extends CDbMigration
{
    public function safeUp()
    {
        $this->execute("CREATE TYPE \"DeviceType\" AS ENUM ('iOS', 'Android')");

        $tableSchema = [
            'Id' => 'serial primary key',
            'UserId' => 'integer not null',
            'Type' => '"DeviceType" not null',
            'Token' => 'text not null',
            'SnsEndpointArn' => 'text not null',
            'SnsSubscriptionArn' => 'text not null'
        ];

        $tableSchema = array_merge($tableSchema, DeletableBehavior::getMigrationFields());
        $tableSchema = array_merge($tableSchema, TimestampableBehavior::getMigrationFields());

        $this->createTable('UserDevice', $tableSchema);
        $this->createIndex('UserDevice_Token', 'UserDevice', 'Token', true);
        $this->addForeignKey('UserDevice_UserId_fKey', 'UserDevice', 'UserId', 'User', 'Id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey('UserDevice_UserId_fKey', 'UserDevice');
        $this->dropTable('UserDevice');
        $this->execute('DROP TYPE "DeviceType"');
    }
}