<?php
namespace partner\controllers\internal\import;

class Telekom13Action extends \partner\components\ImportAction
{

    /**
     * @return int
     */
    public function getEventId()
    {
        return 509;
    }

    /**
     * @return array
     */
    public function getFieldMap()
    {
        return [
            'FirstName' => 1,
            'LastName' => 0,
            'FatherName' => null,
            'Email' => 3,
            'Phone' => null,
            'Company' => 2,
            'Position' => null,
            'Status' => 4,
        ];
    }

    /**
     * @return bool
     */
    public function getIsNotify()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return 'import.csv';
    }

    /**
     * @return bool
     */
    public function getIsEnable()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function getIsDebug()
    {
        return true;
    }

    protected function getRoleId($row)
    {
        $row->Status = mb_strtolower(trim($row->Status), 'utf8');
        switch ($row->Status) {
            case 'участник':
                return 1;
                break;
            case 'партнер':
                return 5;
                break;
            case 'докладчик':
                return 3;
                break;
            case 'организаторы':
                return 6;
                break;
            default:
                return 0;
        }
    }
}