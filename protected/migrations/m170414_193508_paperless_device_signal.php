<?php

class m170414_193508_paperless_device_signal extends CDbMigration
{
    public function up()
    {
        $this->delete('PaperlessDeviceSignal');

        $this->dropColumn('PaperlessDeviceSignal', 'Processed');

        $this->renameColumn('PaperlessDeviceSignal', 'DeviceId', 'DeviceNumber');
        $this->renameColumn('PaperlessDeviceSignal', 'BadgeId', 'BadgeUID');

        $this->addColumn('PaperlessDeviceSignal', 'BadgeTime', 'TIMESTAMP NOT NULL');
        $this->addColumn('PaperlessDeviceSignal', 'Processed', 'BOOLEAN DEFAULT FALSE NOT NULL');
        $this->addColumn('PaperlessDeviceSignal', 'ProcessedTime', 'TIMESTAMP NULL');
        $this->addColumn('PaperlessDeviceSignal', 'CreatedTime', 'TIMESTAMP DEFAULT current_timestamp NOT NULL');

        $this->renameColumn('PaperlessDevice', 'DeviceId', 'DeviceNumber');
    }

    public function down()
    {
        $this->renameColumn('PaperlessDeviceSignal', 'DeviceNumber', 'DeviceId');
        $this->renameColumn('PaperlessDeviceSignal', 'BadgeUID', 'BadgeId');

        $this->dropColumn('PaperlessDeviceSignal', 'BadgeTime');
        $this->dropColumn('PaperlessDeviceSignal', 'ProcessedTime');
        $this->dropColumn('PaperlessDeviceSignal', 'CreatedTime');

        $this->renameColumn('PaperlessDevice', 'DeviceNumber', 'DeviceId');
    }
}