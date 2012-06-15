<?php
interface ISearchPlugin
{
  /**
  * Выполняет поиск и возвращает массив результатов
  *
  * @access public
  * @param string $searchTerm
  * @param array $limitClause Параметр должен быть массивом (начало, конец)
  * @param string $sortBy По релевантности или дате
  * @param string $groupBy Поле для группировки результата
  * @param bool $contentTitleOnly Поиск только заголовков контента
  * @return array
  */
  public function GetSearchResults($limitClause = array(), $sortBy = '', $groupBy = '', $contentTitleOnly = false);
  
  /**
  * Возвращает общее количество найденных поиском полей
  *
  * @access public
  * @param string $searchTerm
  * @param string $groupBy
  * @param bool $contetnTitleOnly
  * @return integer
  */
  public function GetSearchCount($groupBy = '', $contetnTitleOnly = false);
  
  /**
  * Ограничивает выдачу поиска по дате
  *
  * @access  public
  * @param int $begin
  * @param int [$end]
  * @return  void
  */
  public function SetDateRange($begin, $end);
  
  /**
  * Общая функция для добавления особых поисковых ограничений
  *
  * @access public
  * @param string $column Колонка таблицы для установления ограничений
  * @param string $operator Операция применяемая к данному ограничению, например: =, <>, IN, NOT IN
  * @param mixed $value Значение для проверки
  * @return void
  */
  public function SetCondition($column, $operator, $value);
}
