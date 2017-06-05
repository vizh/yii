<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alaris
 * Date: 4/21/13
 * Time: 11:18 PM
 * To change this template use File | Settings | File Templates.
 */

namespace partner\controllers\internal\import;

class Ritconf13Action extends \partner\components\ImportAction
{

    /**
     * @return int
     */
    function getEventId()
    {
        return 523;
    }

    /**
     * @return array
     */
    function getFieldMap()
    {
        return [
            'FirstName' => 0,
            'LastName' => 1,
            'FatherName' => null,
            'Email' => null,
            'Phone' => null,
            'Company' => 2,
            'Position' => null,

            'Status' => 3,
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
        return 'import1.csv';
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
            case 'vip':
                return 14;
                break;
            case 'докладчик':
                return 3;
                break;
            case 'организатор':
                return 6;
                break;
            case 'промо':
                return 43;
                break;
            default:
                return 0;
        }
    }
}