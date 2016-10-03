<?php

class m161002_200918_attribute_translatable extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('AttributeDefinition', 'Translatable', 'BOOLEAN NOT NULL DEFAULT false');
    }

    public function safeDown()
    {
        $this->dropColumn('AttributeDefinition', 'Translatable');
    }
}