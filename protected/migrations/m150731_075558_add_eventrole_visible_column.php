<?php

class m150731_075558_add_eventrole_visible_column extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('EventRole', 'Visible', 'boolean DEFAULT true');
    }

    public function safeDown()
    {
        $this->dropColumn('EventRole', 'Visible');
    }
}