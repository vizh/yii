<?php
class User implements search\models\ISearch
{
  public function find($term) 
  {
    return array(1,2,3,4,5,6,7);
  }
}
