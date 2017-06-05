<?php

class m170409_160832_paperless_event extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('PaperlessEvent', [
            'Id' => 'pk',
            'EventId' => 'integer not null',
            'Subject' => 'string',
            'Text' => 'text',
            'FromName' => 'string',
            'FromAddress' => 'string',
            'File' => 'string',
            'SendOnce' => 'boolean',
            'ConditionLike' => 'boolean',
            'ConditionLikeString' => 'string',
            'ConditionNotLike' => 'boolean',
            'ConditionNotLikeString' => 'string',
            'Active' => 'boolean'
        ]);
        $this->addForeignKey('fk_PaperlessEvent_Event', 'PaperlessEvent', 'EventId', 'Event', 'Id', 'cascade', 'cascade');

        $this->createTable('PaperlessEventLinkDevice', [
            'Id' => 'pk',
            'EventId' => 'integer',
            'DeviceId' => 'string'
        ]);
        $this->addForeignKey('fk_PaperlessEventLinkDevice_Event', 'PaperlessEventLinkDevice', 'EventId', 'PaperlessEvent', 'Id', 'cascade', 'cascade');
        $this->addForeignKey('fk_PaperlessEventLinkDevice_Device', 'PaperlessEventLinkDevice', 'DeviceId', 'PaperlessDevice', 'Id', 'cascade', 'cascade');

        $this->createTable('PaperlessEventLinkRole', [
            'Id' => 'pk',
            'EventId' => 'integer',
            'RoleId' => 'integer'
        ]);
        $this->addForeignKey('fk_PaperlessEventLinkRole_Event', 'PaperlessEventLinkRole', 'EventId', 'PaperlessEvent', 'Id', 'cascade', 'cascade');
        $this->addForeignKey('fk_PaperlessEventLinkRole_Role', 'PaperlessEventLinkRole', 'RoleId', 'EventRole', 'Id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropTable('PaperlessEventLinkDevice');
        $this->dropTable('PaperlessEventLinkRole');
        $this->dropTable('PaperlessEvent');
    }
}