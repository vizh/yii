<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.search.ISearchPlugin');

class EventSearchPlugin implements ISearchPlugin
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
    
    $event = new Event();
    $event = Event::model();        
    $criteria = new CDbCriteria();
    $criteria = Event::GetSearchCriteria($name, $sortBy);

    if ($criteria === null)
    {
      return array();
    }
    else
    {
      return $event->findAll($criteria);
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
    
    $user = new User();
    $user = User::model();        
    $criteria = new CDbCriteria();
    $criteria = User::GetSearchCriteria($name, '');
    
    if (! empty($eventId))
    {
      $event = Event::GetById(intval($eventId));
      return sizeof($event->GetUsers($criteria));
    }
    else
    {
      if ($criteria === null)
      {
        return 0;
      }
      else
      {
        return $user->count($criteria);
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
