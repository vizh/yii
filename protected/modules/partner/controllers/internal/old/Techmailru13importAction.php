<?php
namespace partner\controllers\internal;

class Techmailru13importAction extends \partner\components\ImportAction
{

    /**
     * @return int
     */
    function getEventId()
    {
        return 482;
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
            'Email' => 3,
            'Phone' => 4,
            'Company' => null,
            'Position' => null,

            'Status' => 5,
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
        return 'import2.csv';
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
            case 'участник mail.ru group':
                return 40;
                break;
            case 'докладчик':
                return 3;
                break;
            case 'организатор':
                return 6;
                break;
            case 'сми':
                return 2;
                break;
            default:
                return 0;
        }
    }
}