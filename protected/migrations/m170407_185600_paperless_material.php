<?php

class m170407_185600_paperless_material extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('PaperlessMaterial', [
            'Id' => 'pk',
            'EventId' => 'integer not null',
            'Name' => 'string',
            'Comment' => 'text',
            'File' => 'string',
            'Active' => 'boolean'
        ]);
        $this->addForeignKey('fk_PaperlessMaterial_Event', 'PaperlessMaterial', 'EventId', 'Event', 'Id', 'cascade', 'cascade');

        $this->createTable('PaperlessMaterialLinkRole', [
            'Id' => 'pk',
            'MaterialId' => 'integer',
            'RoleId' => 'integer'
        ]);
        $this->addForeignKey('fk_PaperlessMaterialLinkRole_Material', 'PaperlessMaterialLinkRole', 'MaterialId', 'PaperlessMaterial', 'Id', 'cascade', 'cascade');
        $this->addForeignKey('fk_PaperlessMaterialLinkRole_Role', 'PaperlessMaterialLinkRole', 'RoleId', 'EventRole', 'Id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropTable('PaperlessMaterialLinkRole');
        $this->dropTable('PaperlessMaterial');
    }
}