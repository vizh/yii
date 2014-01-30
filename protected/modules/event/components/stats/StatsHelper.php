<?php
namespace event\components\stats;

/**
 * Class StatsHelper
 *
 * Хелпер для статистики
 * @package event\components\stats
 */
class StatsHelper
{
  public static function getRoles($eventId)
  {
    return \event\models\Role::model()->findAll([
      'condition' => '"EventId" = :eventId',
      'params' => [':eventId' => $eventId],
      'join' => 'INNER JOIN "EventParticipant" "p" ON "t"."Id" = "p"."RoleId"',
      'group' => '"t"."Id"',
      'order' => 'COUNT("t"."Id")'
    ]);
  }

  public static function getStartDate($eventId)
  {
    return \Yii::app()->db->createCommand()
        ->select('DATE("t"."UpdateTime")')
        ->from('EventParticipant t')
        ->where('"t"."EventId" = :eventId', [':eventId' => $eventId])
        ->order('UpdateTime')
        ->limit(1)
        ->queryScalar();
  }

  public static function getEndDate($eventId)
  {
    return \Yii::app()->db->createCommand()
        ->select('DATE("t"."UpdateTime")')
        ->from('EventParticipant t')
        ->where('"t"."EventId" = :eventId', [':eventId' => $eventId])
        ->order('UpdateTime DESC')
        ->limit(1)
        ->queryScalar();
  }

  /**
   * Возвращает временные интервалы, по которым будет осуществляться выборка статистики
   * @param int $eventId
   * @return array
   */
  public static function getDateIntervals($eventId)
  {
    $startDate = new \DateTime(\Yii::app()->db->createCommand()
        ->select('DATE("t"."UpdateTime")')
        ->from('EventParticipant t')
        ->where('"t"."EventId" = :eventId', [':eventId' => $eventId])
        ->order('UpdateTime')
        ->limit(1)
        ->queryScalar());

    $endDate = new \DateTime(\Yii::app()->db->createCommand()
        ->select('DATE("t"."UpdateTime")')
        ->from('EventParticipant t')
        ->where('"t"."EventId" = :eventId', [':eventId' => $eventId])
        ->order('UpdateTime DESC')
        ->limit(1)
        ->queryScalar());

    $interval = $endDate->diff($startDate);
    /*if ($interval->m > 8)
      return self::createIntervalsByMonths($startDate, $endDate);
    elseif ($interval->m <= 8 || $interval->d > 28)
      return self::createIntervalsByWeeks($startDate, $endDate);
    else*/
      return self::createIntervalsByDays($startDate, $endDate);
  }

  /**
   * Формирует временные интервалы по месяцам
   * @param \DateTime $startDate
   * @param \DateTime $endDate
   * @return array
   */
  private static function createIntervalsByMonths(\DateTime $startDate, \DateTime $endDate)
  {
    $intervals = [];
    $startRangeDate = new \DateTime($endDate->format('Y-m-1'));
    $endRangeDate = clone $endDate;
    while ($endRangeDate > $startDate)
    {
      $intervals[] = [
        $startRangeDate->format('Y-m-d'),
        $endRangeDate->format('Y-m-d')
      ];

      $endRangeDate = $startRangeDate->sub(new \DateInterval('P1D'));
      $startRangeDate = new \DateTime($endRangeDate->format('Y-m-1'));
      if ($startRangeDate < $startDate)
        $startRangeDate = clone $startDate;
    }
    return array_reverse($intervals);
  }

  /**
   * Формирует временные интервалы по неделям
   * @param \DateTime $startDate
   * @param \DateTime $endDate
   * @return array
   */
  private static function createIntervalsByWeeks(\DateTime $startDate, \DateTime $endDate)
  {
    $intervals = [];
    $startRangeDate = clone $startDate;
    // Вычисляем дату конца недели, далее шаг пойдет по 7 дней. Для этого добавляем к началу
    // периода число оставшихся дней до конца недели
    $endRangeDate = $startDate->add(new \DateInterval('P'.(7 - $startDate->format('N')).'D'));
    while ($startRangeDate < $endDate)
    {
      $intervals[] = [
        $startRangeDate->format('Y-m-d'),
        $endRangeDate->format('Y-m-d')
      ];

      $startRangeDate = $endRangeDate->add(new \DateInterval('P1D'));
      $endRangeDate = clone $startRangeDate;
      $endRangeDate->add(new \DateInterval('P7D'));
      if ($endRangeDate > $endDate)
        $endRangeDate = clone $endDate;
    }
    return $intervals;
  }

  /**
   * Формирует временные интервалы по дням
   * @param \DateTime $startDate
   * @param \DateTime $endDate
   * @return array
   */
  private static function createIntervalsByDays(\DateTime $startDate, \DateTime $endDate)
  {
    $intervals = [];
    $startRangeDate = clone $startDate;
    // Вычисляем дату конца недели, далее шаг пойдет по 7 дней. Для этого добавляем к началу
    // периода число оставшихся дней до конца недели
    $endRangeDate = clone $startDate;
    while ($startRangeDate <= $endDate)
    {
      $intervals[] = [
        $startRangeDate->format('Y-m-d'),
        $endRangeDate->format('Y-m-d')
      ];

      $startRangeDate = $endRangeDate->add(new \DateInterval('P1D'));
      $endRangeDate = clone $startRangeDate;
      if ($endRangeDate > $endDate)
        $endRangeDate = clone $endDate;
    }
    return $intervals;
  }

} 