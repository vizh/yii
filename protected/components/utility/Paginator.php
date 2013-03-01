<?php
namespace application\components\utility;

class Paginator
{
  private $count;
  private $params = array();

  public $page;
  public $onPage = 20;
  public $pages = 13;

  /**
   * @param int $count
   * @param array $params
   */
  public function __construct($count, $params = array())
  {
    $this->count = $count;
    $this->params = $params;
    $this->page = (int) \Yii::app()->request->getParam('page', 1);
    $this->page = max($this->page, 1);
  }

  /**
   * @return int
   */
  public function getCount()
  {
    return $this->count;
  }

  /**
   * @return \CDbCriteria
   */
  public function getCriteria()
  {
    $criteria = new \CDbCriteria();
    $criteria->limit = $this->onPage;
    $criteria->offset = ($this->page - 1) * $this->onPage;
    return $criteria;
  }
}