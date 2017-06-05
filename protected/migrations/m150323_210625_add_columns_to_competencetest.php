<?php

class m150323_210625_add_columns_to_competencetest extends CDbMigration
{
    public function up()
    {
        $this->addColumn('CompetenceTest', 'BeforeText', 'text');
        $this->addColumn('CompetenceTest', 'AfterText', 'text');
        $this->addColumn('CompetenceTest', 'ParticipantsOnly', 'bool DEFAULT false');
    }

    public function safeDown()
    {
        // Не можем откатывать миграции, опубликованные в production
        //$this->dropColumn('CompetenceTest', 'BeforeText');
        //$this->dropColumn('CompetenceTest', 'AfterText');
        //$this->dropColumn('CompetenceTest', 'ParticipantsOnly');
        return false;
    }
}