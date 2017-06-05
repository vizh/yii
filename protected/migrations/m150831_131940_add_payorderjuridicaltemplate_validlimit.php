<?php

class m150831_131940_add_payorderjuridicaltemplate_validlimit extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('PayOrderJuridicalTemplate', 'ValidityDays', 'integer NOT NULL DEFAULT 5');
        $this->addColumn('PayOrderJuridicalTemplate', 'ShowValidity', 'boolean DEFAULT true');
    }

    public function safeDown()
    {
        $this->dropColumn('PayOrderJuridicalTemplate', 'ValidityDays');
        $this->dropColumn('PayOrderJuridicalTemplate', 'ShowValidity');
    }
}