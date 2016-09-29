<?php

class m160906_070411_section_short_name extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('EventSection', 'ShortTitle', 'character varying(1000) null');
    }

    public function safeDown()
    {
        $this->dropColumn('EventSection', 'ShortTitle');
    }
}