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
    return array(
      'FirstName' => 0,
      'LastName' => 1,
      'FatherName' => null,
      'Email' => 3,
      'Phone' => null,
      'Company' => 2,
      'Position' => null,

      'Status' => null,
    );
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
    return 'import1.csv';
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
    return 2;
  }
}