<?php

class m170711_200644_user_settings extends CDbMigration
{
    public function up()
    {
        $this->addColumn('UserSettings', 'UnsubscribePush', 'boolean not null default false');
    }

    public function down()
    {
        $this->dropColumn('UserSettings', 'UnsubscribePush');
    }
}