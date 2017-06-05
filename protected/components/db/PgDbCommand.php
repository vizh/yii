<?php
namespace application\components\db;

class PgDbCommand extends \CDbCommand
{
    public function bindValue($name, $value, $dataType = null)
    {
        $this->prepare();
        $_statement = $this->getPdoStatement();
        if ($value === false) {
            $_statement->bindValue($name, 'FALSE', \PDO::PARAM_STR);
        } else if ($value === true) {
            $_statement->bindValue($name, 'TRUE', \PDO::PARAM_STR);
        } else {
            return parent::bindValue($name, $value, $dataType);
        }
        return $this;
    }

}
