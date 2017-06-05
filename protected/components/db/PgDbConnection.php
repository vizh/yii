<?php
namespace application\components\db;

class PgDbConnection extends \CDbConnection
{
    public function createCommand($query = null)
    {
        $this->setActive(true);
        return new PgDbCommand($this, $query);
    }
}
