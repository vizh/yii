<?php
namespace partner\controllers\internal\import;

class Rgw13Action extends \partner\components\ImportAction
{

    /**
     * @return int
     */
    public function getEventId()
    {
        return 585;
    }

    /**
     * @return array
     */
    public function getFieldMap()
    {
        return [
            'FirstName' => 3,
            'LastName' => 2,
            'FatherName' => 4,
            'Email' => 5,
            'Phone' => null,
            'Company' => 1,
            'Position' => null,

            'Status' => 0,
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
            case 'виртуальный участник':
                return 24;
                break;
            case 'посетитель':
                return 38;
                break;
            case 'спикер':
                return 3;
                break;
            case 'участник конференции':
                return 1;
                break;
            case 'экспонент':
                return 12;
                break;
            case 'сми':
                return 2;
                break;
            case 'организатор':
                return 6;
                break;
            default:
                return 0;
        }
    }
}