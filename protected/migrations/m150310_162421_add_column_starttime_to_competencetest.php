<?php
namespace application\migrations;

class m150310_162421_add_column_starttime_to_competencetest extends \CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('CompetenceTest', 'EndTime', 'timestamp NULL');
        return true;
    }

    public function safeDown()
    {
        // Не можем откатывать миграции, опубликованные в production
        //$this->dropColumn('PayOrderItem', 'UpdateTime');
        return false;
    }
} 