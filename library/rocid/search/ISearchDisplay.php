<?php

interface ISearchDisplay
{
  /**
  * Преобразует найденный результат для вывода
  *
  * @access public
  * @param array $searchRow Массив данных, из ISearchIndexPlugin
  * @return string Преобразованный контент, готовый к выводу
  */
  public function FormatContent($searchRow);

  /**
  * Возвращает html для отображения окна поиска на странице "Расширенного поиска"
  *
  * @access public
  * @return string Html для вывода пользователю
  */  
  public function GetFilterHtml();
  
  /**
  * Возвращает массив, используемый в SetCondition в ISearchIndexPlugin
  *
  * @access public
  * @param array $data Массив данных для фильтрования
  * @return array Массив с колонкой, оператором, и значением, для использования в SetCondition
  */
  public function BuildFilterSql($data);

}
