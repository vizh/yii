<?php
namespace event\components\stats;

/**
 * Class RegistrationsAll
 *
 * Собирает статистику по всем регистрациям
 * @package event\components\stats
 */
class RegistrationsAll
{
  /**
   * @var int Идентификатор мероприятия
   */
  private $_eventId;

  /**
   * @param int $eventId
   */
  public function __construct($eventId)
  {
    $this->_eventId = $eventId;
  }

  /**
   * Возвращает статистику по всем регистрациям
   * @return array
   */
  public function getAllStat()
  {
    $stats = \Yii::app()->db->createCommand()
        ->select('CAST("Day" AS DATE) AS "Date", COUNT("EventId") AS "Count"')
        ->from('generate_series(:startDate::timestamp, :endDate, \'1 day\') "Day"')
        ->leftJoin(
          'EventParticipant p',
          'CAST("Day" AS DATE) = CAST("p"."UpdateTime" AS DATE) AND "p"."EventId" = :eventId',
          [':eventId' => $this->_eventId]
        )
        ->group('CAST("Day" AS DATE)')
        ->order('CAST("Day" AS DATE)')
        ->query([':startDate' => StatsHelper::getStartDate($this->_eventId), ':endDate' => StatsHelper::getEndDate($this->_eventId)]);

    $dateFormatter = new \CDateFormatter(\Yii::app()->locale);
    $result = []; $all = 0;
    foreach ($stats as $v)
    {
      $all += $v['Count'];
      $result[$dateFormatter->format('d MMM', strtotime($v['Date']))] = $all;
    }

    return $result;
  }

  /**
   * Возвращает статистику по всем ролям
   * @return array
   */
  public function getStatByRoles()
  {
    $result = [];
    $roles = StatsHelper::getRoles($this->_eventId);
    foreach ($roles as $role)
    {
      foreach (self::getStatByRole($role->Id) as $date => $count)
        $result[$date][$role->Title] = $count;
    }
    return $result;
  }

  /**
   * Возвращает статистику по заданной роли
   * @param int $roleId
   * @return array
   */
  public function getStatByRole($roleId)
  {
    $stats = \Yii::app()->db->createCommand()
        ->select('CAST("Day" AS DATE) AS "Date", COUNT("EventId") AS "Count"')
        ->from('generate_series(:startDate::timestamp, :endDate, \'1 day\') "Day"')
        ->leftJoin(
          'EventParticipant p',
          'CAST("Day" AS DATE) = CAST("p"."UpdateTime" AS DATE) AND "p"."EventId" = :eventId AND "p"."RoleId" = :roleId',
          [':eventId' => $this->_eventId, ':roleId' => $roleId]
        )
        ->group('CAST("Day" AS DATE)')
        ->order('CAST("Day" AS DATE)')
        ->query([':startDate' => StatsHelper::getStartDate($this->_eventId), ':endDate' => StatsHelper::getEndDate($this->_eventId)]);

    $dateFormatter = new \CDateFormatter(\Yii::app()->locale);
    $result = []; $all = 0;
    foreach ($stats as $v)
    {
      $all += $v['Count'];
      $result[$dateFormatter->format('d MMM', strtotime($v['Date']))] = $all;
    }
    return $result;
  }


}