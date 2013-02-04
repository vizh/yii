<?php
namespace search\components\interfaces;
interface ISearch 
{
  public function bySearch($term, $locale = null, $useAnd = true);
  public function getSearchData();
}
