<?php

class m150917_143503_payaccount_cabinetjuridicalcreateinfo extends CDbMigration
{
    public function up()
    {
        $this->addColumn('PayAccount', 'CabinetJuridicalCreateInfo', 'varchar(255) NULL');
    }

    public function down()
    {
        $this->dropColumn('PayAccount', 'CabinetJuridicalCreateInfo');
    }
}