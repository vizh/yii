<?php

class m170414_103058_paperless_devices extends CDbMigration
{
    public function up()
    {
        $this->dropTable('PaperlessEventLinkDevice');
        $this->dropTable('PaperlessEventLinkRole');
        $this->dropTable('PaperlessEvent');
        $this->dropTable('PaperlessMaterialLinkRole');
        $this->dropTable('PaperlessMaterial');
        $this->dropTable('PaperlessDevice');

        $this->createTable('PaperlessDevice', [
            'Id' => 'pk',
            'EventId' => 'serial NOT NULL',
            'DeviceId' => 'serial NOT NULL',
            'Active' => 'boolean',
            'Name' => 'string',
            'Type' => 'string',
            'Comment' => 'text'
        ]);
        $this->addForeignKey('fk_PaperlessDevice_Event', 'PaperlessDevice', 'EventId', 'Event', 'Id', 'cascade', 'cascade');

        $this->createTable('PaperlessMaterial', [
            'Id' => 'pk',
            'EventId' => 'integer NOT NULL',
            'Active' => 'boolean',
            'Visible' => 'boolean',
            'Name' => 'string',
            'File' => 'string',
            'Comment' => 'text',
            'PartnerName' => 'string',
            'PartnerSite' => 'string',
            'PartnerLogo' => 'string'
        ]);
        $this->addForeignKey('fk_PaperlessMaterial_Event', 'PaperlessMaterial', 'EventId', 'Event', 'Id', 'cascade', 'cascade');

        $this->createTable('PaperlessMaterialLinkRole', [
            'Id' => 'pk',
            'MaterialId' => 'integer',
            'RoleId' => 'integer'
        ]);
        $this->addForeignKey('fk_PaperlessMaterialLinkRole_Material', 'PaperlessMaterialLinkRole', 'MaterialId', 'PaperlessMaterial', 'Id', 'cascade', 'cascade');
        $this->addForeignKey('fk_PaperlessMaterialLinkRole_Role', 'PaperlessMaterialLinkRole', 'RoleId', 'EventRole', 'Id', 'cascade', 'cascade');

        $this->createTable('PaperlessEvent', [
            'Id' => 'pk',
            'EventId' => 'integer not null',
            'Active' => 'boolean',
            'Subject' => 'string',
            'Text' => 'text',
            'FromName' => 'string',
            'FromAddress' => 'string',
            'File' => 'string',
            'SendOnce' => 'boolean',
            'ConditionLike' => 'boolean',
            'ConditionLikeString' => 'string',
            'ConditionNotLike' => 'boolean',
            'ConditionNotLikeString' => 'string'
        ]);
        $this->addForeignKey('fk_PaperlessEvent_Event', 'PaperlessEvent', 'EventId', 'Event', 'Id', 'cascade', 'cascade');

        $this->createTable('PaperlessEventLinkDevice', [
            'Id' => 'pk',
            'EventId' => 'integer',
            'DeviceId' => 'serial NOT NULL'
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

        $this->createTable('PaperlessDeviceSignal', [
            'Id' => 'pk',
            'EventId' => 'serial NOT NULL',
            'DeviceId' => 'serial NOT NULL',
            'BadgeId' => 'serial NOT NULL',
            'Processed' => 'boolean',
        ]);
        $this->createIndex('PaperlessDeviceSignal_EventId_DeviceId_idx', 'PaperlessDeviceSignal', ['EventId', 'DeviceId']);
        $this->createIndex('PaperlessDeviceSignal_Processed_idx', 'PaperlessDeviceSignal', ['EventId', 'DeviceId']);
        $this->addForeignKey('fk_PaperlessDeviceSignal_Device', 'PaperlessDeviceSignal', 'DeviceId', 'PaperlessDevice', 'Id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('PaperlessDeviceSignal');
    }
}