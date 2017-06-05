<?php

class m160629_223331_pay_order_import extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('PayOrderImport', [
            'Id' => 'serial PRIMARY KEY',
            'CreationTime' => 'timestamp without time zone',
        ]);

        $this->createTable('PayOrderImportOrder', [
            'Id' => 'serial PRIMARY KEY',
            'ImportId' => 'integer not null',
            'Data' => 'text not null',
            'OrderNumber' => 'varchar(255) null',
            'OrderId' => 'integer null',
            'Approved' => 'boolean not null default false'
        ]);
        $this->addForeignKey('PayOrderImportOrder_ImportId_fkey', 'PayOrderImportOrder', 'ImportId', 'PayOrderImport', 'Id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('PayOrderImportOrder');
        $this->dropTable('PayOrderImport');
    }
}