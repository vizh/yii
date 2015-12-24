<?php

class m151224_122656_eventuserdata_trigger extends CDbMigration
{
    public function up()
    {
        $this->execute('
            CREATE TRIGGER "UpdateUser"
            AFTER INSERT OR UPDATE OR DELETE ON "public"."EventUserData"
            FOR EACH ROW
            EXECUTE PROCEDURE "UserUpdateTimeByUserId"();
        ');
    }

    public function down()
    {
        $this->execute('DROP TRIGGER "UpdateUser" ON "public"."EventUserData"');
    }
}