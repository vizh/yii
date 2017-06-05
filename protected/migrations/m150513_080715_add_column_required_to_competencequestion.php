<?php

class m150513_080715_add_column_required_to_competencequestion extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('CompetenceQuestion', 'Required', 'boolean DEFAULT true');
    }

    public function safeDown()
    {
        $this->dropColumn('CompetenceQuestion', 'Required');
    }
}