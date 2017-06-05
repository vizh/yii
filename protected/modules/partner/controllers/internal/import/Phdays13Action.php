<?php
namespace partner\controllers\internal\import;

class Phdays13Action extends \partner\components\ImportAction
{

    /**
     * @return int
     */
    public function getEventId()
    {
        return 497;
    }

    /**
     * @return array
     */
    public function getFieldMap()
    {
        return [
            'FirstName' => 1,
            'LastName' => 0,
            'FatherName' => 2,
            'Email' => 5,
            'Phone' => 6,
            'Company' => 3,
            'Position' => 4,

            'Status' => 7,
        ];
    }

    /**
     * @return bool
     */
    public function getIsUserVisible()
    {
        return true;
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
        return 'import5.csv';
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
            case 'participant':
                return 1;
                break;
            case 'press':
                return 2;
                break;
            case 'speaker':
                return 3;
                break;
            case 'vip':
                return 14;
                break;
            case 'организаторы':
                return 6;
                break;
            case 'ctf':
                return 1;
                break;
            default:
                return 0;
        }
    }
}