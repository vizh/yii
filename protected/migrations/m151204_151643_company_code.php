<?php

class m151204_151643_company_code extends CDbMigration
{
    public function up()
    {
        $this->addColumn('Company', 'Code', 'varchar(255)');
    }

    public function down()
    {
        $this->dropColumn('Company', 'Code');
    }
}