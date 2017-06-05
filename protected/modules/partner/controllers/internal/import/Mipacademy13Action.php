<?php
namespace partner\controllers\internal\import;

class Mipacademy13Action extends \partner\components\ImportAction
{

    /**
     * @return int
     */
    public function getEventId()
    {
        return 488;
    }

    /**
     * @return array
     */
    public function getFieldMap()
    {
        return [
            'FirstName' => 0,
            'LastName' => 1,
            'FatherName' => null,
            'Email' => null,
            'Phone' => null,
            'Company' => null,
            'Position' => null,

            'Status' => 2,
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
            case 'учасник':
                return 1;
                break;
            case 'пресса':
                return 2;
                break;
            case 'спикер':
                return 3;
                break;
            case 'организатор':
                return 6;
                break;
            default:
                return 0;
        }
    }
}