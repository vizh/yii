<?php

class m150508_084203_add_column_public_to_eventparticipant extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('AttributeDefinition', 'Public', 'boolean DEFAULT true');
    }

    public function safeDown()
    {
        $this->dropColumn('AttributeDefinition', 'Public');
    }
}