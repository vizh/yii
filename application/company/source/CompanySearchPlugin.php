<?php
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('library.rocid.search.ISearchPlugin');

class CompanySearchPlugin implements ISearchPlugin
{
  /**
  * Выполняет поиск и возвращает массив результатов
  *
  * @access public
  * @param string $searchTerm
  * @param array $limitClause Параметр должен быть массивом (начало, конец)[включительно]
  * @param string $sortBy По какому полю сортировка
  * @param string $groupBy Поле для группировки результата
  * @param bool $contentTitleOnly Поиск только заголовков контента
  * @return array[CActiveRecord]
  */
  public function GetSearchResults($limitClause = array(), $sortBy = '', $groupBy = '', $contentTitleOnly = false)
  {    
    $name = Registry::GetRequestVar('Name');
    $eventId = Registry::GetRequestVar('EventId');
    
    $company = new Company();
    $company = Company::model();        
    $criteria = new CDbCriteria();
    $criteria = Company::GetSearchCriteria($name, $sortBy);
    if ($criteria !== null && ! empty($limitClause) && isset($limitClause[0]) 
      && isset($limitClause[1]) && $limitClause[0] <= $limitClause[1])
    {
      $criteria->offset = $limitClause[0];
      $criteria->limit = $limitClause[1] - $limitClause[0] + 1;
    }
    
    if (! empty($eventId))
    {
      $event = Event::GetById(intval($eventId));
      return $event->GetCompanies($criteria);
    }
    else
    {
      if ($criteria === null)
      {
        return array();
      }
      else
      {
        return $company->findAll($criteria);
      }      
    }
  }
  
  /**
  * Возвращает общее количество найденных поиском полей
  *
  * @access public
  * @param string $searchTerm
  * @param string $groupBy
  * @param bool $contetnTitleOnly
  * @return integer
  */
  public function GetSearchCount($groupBy = '', $contetnTitleOnly = false)
  {
    $name = Registry::GetRequestVar('Name');
    $eventId = Registry::GetRequestVar('EventId');
    
    $company = new Company();
    $company = Company::model();        
    $criteria = new CDbCriteria();
    $criteria = Company::GetSearchCriteria($name, '');
    
    if (! empty($eventId))
    {
      $event = Event::GetById(intval($eventId));
      return sizeof($event->GetCompanies($criteria));
    }
    else
    {
      if ($criteria === null)
      {
        return 0;
      }
      else
      {
        return $company->count($criteria);
      }      
    }
  }
  
  /**
  * Ограничивает выдачу поиска по дате
  *
  * @access  public
  * @param int $begin
  * @param int [$end]
  * @return  void
  */
  public function SetDateRange($begin, $end)
  {
    
  }
  
  /**
  * Общая функция для добавления особых поисковых ограничений
  *
  * @access public
  * @param string $column Колонка таблицы для установления ограничений
  * @param string $operator Операция применяемая к данному ограничению, например: =, <>, IN, NOT IN
  * @param mixed $value Значение для проверки
  * @return void
  */
  public function SetCondition($column, $operator, $value)
  {
    
  }
}
