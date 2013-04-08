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
    return array(

      'FirstName' => 0,
      'LastName' => 1,
      'FatherName' => null,
      'Email' => 2,
      'Phone' => 3,
      'Company' => 4,
      'Position' => 5,

      'Status' => 7,
    );
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
    return true;
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
    switch ($row->Status)
    {
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
      default:
        return 0;
    }
  }
}