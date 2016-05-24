<?php

class m160524_081432_competence_render_event_header extends CDbMigration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('CompetenceTest', 'RenderEventHeader', 'bool DEFAULT false');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('CompetenceTest', 'RenderEventHeader');
    }
}
