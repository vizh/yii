<?php

class m150121_172324_add_column_updatetime_to_payorderitems extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('PayOrderItem', 'UpdateTime', 'timestamp NULL DEFAULT (\'now\'::text)::timestamp(0) without time zone');
        return true;
    }

    public function safeDown()
    {
        // Не можем откатывать миграции, опубликованные в production
        //$this->dropColumn('PayOrderItem', 'UpdateTime');
        return false;
    }
}