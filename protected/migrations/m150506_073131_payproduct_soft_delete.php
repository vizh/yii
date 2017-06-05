<?php

class m150506_073131_payproduct_soft_delete extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('PayProduct', 'Deleted', 'boolean DEFAULT false');
        $this->addColumn('PayProduct', 'DeletionTime', 'timestamp NULL DEFAULT NULL');
        $this->addColumn('PayProductPrice', 'Deleted', 'boolean DEFAULT false');
        $this->addColumn('PayProductPrice', 'DeletionTime', 'timestamp NULL DEFAULT NULL');
        $this->addColumn('PayProductAttribute', 'Deleted', 'boolean DEFAULT false');
        $this->addColumn('PayProductAttribute', 'DeletionTime', 'timestamp NULL DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('PayProduct', 'Deleted');
        $this->dropColumn('PayProduct', 'DeletionTime');
        $this->dropColumn('PayProductPrice', 'Deleted');
        $this->dropColumn('PayProductPrice', 'DeletionTime');
        $this->dropColumn('PayProductAttribute', 'Deleted');
        $this->dropColumn('PayProductAttribute', 'DeletionTime');
    }

}