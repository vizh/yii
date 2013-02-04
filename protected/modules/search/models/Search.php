<?php
namespace search\models;
class Search
{
  protected $_models = array();
  public function appendModel(\search\components\interfaces\ISearch $model)
  {
    $this->_models[get_class($model)] = $model;
    return $this;
  }

  public function findAll($term, $locale = null) 
  {
    $result = array();
    foreach ($this->_models as $class => $model)
    {
      $foundItems = $model->bySearch($term, $locale)->findAll();
      foreach ($foundItems as $item)
      {
        $result[$class][] = $item;
      }
    }
    return $result;
  }
}

?>
