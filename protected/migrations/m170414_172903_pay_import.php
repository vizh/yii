<?php

class m170414_172903_pay_import extends CDbMigration
{
	public function safeUp()
	{
	    $this->renameTable('PayOrderImportOrder', 'PayOrderImportEntry');
	    $this->dropForeignKey('PayOrderImportOrder_ImportId_fkey', 'PayOrderImportEntry');
        $this->addForeignKey('PayOrderImportEntry_ImportId_fkey', 'PayOrderImportEntry', 'ImportId', 'PayOrderImport', 'Id', 'CASCADE', 'CASCADE');

        $this->createTable('PayOrderImportOrder', [
            'Id' => 'pk',
            'EntryId' => 'integer not null',
            'OrderId' => 'integer',
            'Approved' => 'boolean'
        ]);
        $this->addForeignKey('PayOrderImportOrder_EntryId_fkey', 'PayOrderImportOrder', 'EntryId', 'PayOrderImportEntry', 'Id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('PayOrderImportOrder_OrderId_fkey', 'PayOrderImportOrder', 'OrderId', 'PayOrder', 'Id', 'CASCADE', 'CASCADE');

        $this->execute('insert into "PayOrderImportOrder"
            select nextval(\'"PayOrderImportOrder_Id_seq"\'), "Id", "OrderId", "Approved" from "PayOrderImportEntry"');

        $this->dropColumn('PayOrderImportEntry', 'Approved');
        $this->dropColumn('PayOrderImportEntry', 'OrderId');
        $this->dropColumn('PayOrderImportEntry', 'OrderNumber');

	}

	public function safeDown()
	{
	    $this->addColumn('PayOrderImportEntry', 'OrderNumber', 'string');
	    $this->addColumn('PayOrderImportEntry', 'OrderId', 'integer');
	    $this->addColumn('PayOrderImportEntry', 'Approved', 'boolean');

	    $this->dropTable('PayOrderImportOrder');

        $this->renameTable('PayOrderImportEntry', 'PayOrderImportOrder');
        $this->dropForeignKey('PayOrderImportEntry_ImportId_fkey', 'PayOrderImportOrder');
        $this->addForeignKey('PayOrderImportOrder_ImportId_fkey', 'PayOrderImportOrder', 'ImportId', 'PayOrderImport', 'Id', 'CASCADE', 'CASCADE');
	}
}