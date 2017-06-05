<?php
namespace partner\controllers\internal\import;

class Demo13Action extends \partner\components\ImportAction
{

    /**
     * @return int
     */
    public function getEventId()
    {
        return 452;
    }

    /**
     * @return array
     */
    public function getFieldMap()
    {
        return [
            'FirstName' => 1,
            'LastName' => 2,
            'FatherName' => null,
            'Email' => 4,
            'Phone' => null,
            'Company' => 3,
            'Position' => null,

            'Status' => 5,
        ];
    }

    /**
     * @return bool
     */
    public function getIsUserVisible()
    {
        return false;
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
        return 'import2.csv';
    }

    /**
     * @return bool
     */
    public function getIsEnable()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function getIsDebug()
    {
        return false;
    }

    protected function getRoleId($row)
    {
        $row->Status = mb_strtolower(trim($row->Status), 'utf8');
        switch ($row->Status) {
            case 'partner':
                return 5;
                break;
            case 'demonstrator':
                return 12;
                break;
            case 'speaker':
                return 3;
                break;
            case 'organizer':
                return 6;
                break;
            case 'press':
                return 2;
                break;
            default:
                return 0;
        }
    }

}