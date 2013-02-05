<?php
namespace search\models;
class Search
{
  protected $_page;
  protected $_pageSize;
  
  protected $_models = array();
  
  public function setPageSettings($page, $size)
  {
    $this->_page = $page;
    $this->_pageSize = $size;
  }

  public function appendModel(\search\components\interfaces\ISearch $model)
  {
    $this->_models[get_class($model)] = $model;
    return $this;
  }

  public function findAll($term, $locale = null) 
  {
    $result = new \stdClass();
    foreach ($this->_models as $class => $model)
    {
      $criteria = $model->bySearch($term, $locale)->getDbCriteria();
      $result->Counts[$class] = $model->count($criteria);      
      if ($result->Counts[$class] > 0)
      {
        if ($this->_page !== null && $this->_pageSize !== null)
        {
          $criteria->offset = ($this->_page - 1) * $this->_pageSize;
          $criteria->limit  = $this->_page * $this->_pageSize;
        }
        $result->Results[$class] = $model->findAll($criteria);
      }
    }
    return $result;
  }
}

?>
