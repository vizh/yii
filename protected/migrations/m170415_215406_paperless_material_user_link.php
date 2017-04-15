<?php

class m170415_215406_paperless_material_user_link extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('PaperlessMaterialLinkUser', [
            'Id' => 'pk',
            'MaterialId' => 'serial not null',
            'UserId' => 'serial not null'
        ]);
        $this->addForeignKey('fk_PaperlessMaterialLinkUser_Material', 'PaperlessMaterialLinkUser', 'MaterialId', 'PaperlessMaterial', 'Id', 'cascade', 'cascade');
        $this->addForeignKey('fk_PaperlessMaterialLinkUser_User', 'PaperlessMaterialLinkUser', 'UserId', 'User', 'Id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropTable('PaperlessMaterialLinkUser');
    }
}