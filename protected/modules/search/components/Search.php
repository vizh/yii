<?php
class Search implements \search\components\interfaces\ISearch 
{
  protected $_searchObjects = array();
  public function appendObject(\search\components\interfaces\ISearch $obj)
  {
    $this->_searchObjects[get_class($obj)] = $obj;
  }

  public function find($term) 
  {
    $result = array();
    foreach ($this->_searchObjects as $class => $obj)
    {
      $result[$class] = $obj->find($term);
    }
    return $result;
  }
}

?>
