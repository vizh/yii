<?php
namespace partner\controllers\internal\import;

class Snce13Action extends \partner\components\ImportAction
{

    /**
     * @return int
     */
    function getEventId()
    {
        return 469;
    }

    /**
     * @return array
     */
    function getFieldMap()
    {
        return [
            'FirstName' => 2,
            'LastName' => 1,
            'FatherName' => null,
            'Email' => 4,
            'Phone' => 5,
            'Company' => 3,
            'Position' => null,

            'Status' => 0,
        ];
    }

    /**
     * @return bool
     */
    function getIsNotify()
    {
        return false;
    }

    /**
     * @return string
     */
    function getFileName()
    {
        return 'import.csv';
    }

    /**
     * @return bool
     */
    function getIsEnable()
    {
        return false;
    }

    /**
     * @return bool
     */
    function getIsDebug()
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
            case 'посетитель':
                return 38;
                break;
            case 'конференция':
                return 41;
                break;
            case 'организатор':
                return 6;
                break;
            case 'сми':
                return 2;
                break;
            case 'speed dealing':
                return 42;
                break;
            default:
                return 0;
        }
    }

}