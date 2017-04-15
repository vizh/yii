<?php

class m170415_195335_paperless_event_materials_link extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('PaperlessEventLinkMaterial', [
            'Id' => 'pk',
            'EventId' => 'serial not null',
            'MaterialId' => 'serial not null'
        ]);
        $this->addForeignKey('fk_PaperlessEventLinkMaterial_Event', 'PaperlessEventLinkMaterial', 'EventId', 'PaperlessEvent', 'Id', 'cascade', 'cascade');
        $this->addForeignKey('fk_PaperlessEventLinkMaterial_Material', 'PaperlessEventLinkMaterial', 'MaterialId', 'PaperlessMaterial', 'Id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropTable('PaperlessEventLinkMaterial');
    }
}