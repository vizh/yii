<?php
namespace pay\models\forms\admin;

/**
 * Class BookingSearch
 * Поиск номеров
 * @package pay\models\forms\admin
 */
class BookingSearch extends \CFormModel
{
  public $Hotel = [];
  public $Housing = [];
  public $Category = [];
  public $PlaceTotal = [];
  public $RoomCount = [];

  public $DateIn;
  public $DateOut;
  public $NotFree = false;

  /**
   * @var array Аттрибуты по которым идем группировка
   */
  private static $_attributeGroups = [
    'Hotel',
    'Housing',
    'Category',
    'PlaceTotal',
    'RoomCount',
    'Visible'
  ];

  /**
   * @var array Даты проведения мероприятия
   */
  private static $_dates = [
    '2014-04-22',
    '2014-04-23',
    '2014-04-24',
    '2014-04-25'
  ];

  private static $_dateRanges;

  /**
   * @var array Группированные возможные значения по каждому из перечисленных в $_attributesGroups атрибуту
   */
  private $_groupValues = [];

  /**
   * @var array Список номеров
   */
  private $_rooms = [];

  /**
   * @return array Правила валидации
   */
  public function rules()
  {
    return [
      ['Hotel, Category, Housing, PlaceTotal, RoomCount', 'validateGroupsArray'],
      ['DateIn, DateOut', 'date', 'format' => 'yyyy-MM-dd'],
      ['NotFree', 'boolean']
    ];
  }

  public function validateGroupsArray($attribute)
  {
    if (!in_array($attribute, array_keys($this->_groupValues)))
    {
      $this->addError($attribute, 'Неизвестный атрибут');
      return;
    }

    if (empty($this->$attribute) || !is_array($this->$attribute))
      return;

    foreach ($this->$attribute as $attr)
    {
      if (empty($attr) || intval($attr) === -1)
        continue;

      if (!in_array($attr, array_keys($this->_groupValues[$attribute])))
      {
        $this->addError($attribute, "Неверное значение для атрибута $attribute!");
      }
    }
  }

  /**
   * Валидируем атрибуты
   * @param $attribute
   */
  public function validateGroups($attribute)
  {
    if (!in_array($attribute, array_keys($this->_groupValues)))
    {
      $this->addError($attribute, 'Неизвестный атрибут');
      return;
    }

    if (empty($this->$attribute))
      return;

    if (!in_array($this->$attribute, array_keys($this->_groupValues[$attribute])))
    {
      $this->addError($attribute, "Неверное значение для атрибута $attribute!");
      return;
    }
  }

  /**
   * Определяем группы значений
   */
  public function init()
  {
    parent::init();
    self::$_dateRanges = $this->makeDateRanges(self::$_dates);
    $this->makeGroupValues();
  }

  /**
   * Заполняет групповые значения
   * @param array $usedAttributes
   */
  private function makeGroupValues($usedAttributes = [])
  {
    $command = \Yii::app()->getDb()->createCommand()
        ->select('ppa.Name, ppa.Value')->from('PayProductAttribute ppa')
        ->leftJoin('PayProduct pp', 'ppa."ProductId" = pp."Id"')
        ->where('pp."EventId" = :EventId AND pp."ManagerName" = :ManagerName')
        ->andWhere('ppa."Name" IN (\'' . implode('\',\'', self::$_attributeGroups) . '\')')
        ->group('ppa.Name, ppa.Value')
        ->order('ppa.Value');

    $idsSubquery = $this->makeProductIdsSubqueries($usedAttributes);
    if (!empty($idsSubquery))
      $command->andWhere('ppa."ProductId" IN ('.$idsSubquery.')');

    $results = $command->query(['EventId' => \BookingController::EventId, 'ManagerName' => 'RoomProductManager']);

    foreach ($this->_groupValues as $groupName => $group)
      if (!in_array($groupName, $usedAttributes))
        unset($this->_groupValues[$groupName]);

    foreach ($results as $row)
    {
      $name = $row['Name'];
      if (!empty($usedAttributes) && in_array($name, $usedAttributes))
        continue;

      if (!isset($this->_groupValues[$name]))
        $this->_groupValues[$name] = [];

      if ($row['Value'] !== '')
        $this->_groupValues[$name][] = $row['Value'];
    }

    foreach (self::$_dates as $date)
      $this->_groupValues['DateIn'][$date] = $this->_groupValues['DateOut'][$date] = $date;

    array_pop($this->_groupValues['DateIn']);
    array_shift($this->_groupValues['DateOut']);
  }

  /**
   * Задаем новые групповые значения
   */
  protected function afterValidate()
  {
    $this->makeGroupValues(['Hotel']);
  }

  /**
   * Возвращает список значений для заданного поля
   * @param string $fieldName
   * @return array
   */
  public function getAttributeValues($fieldName)
  {
    if (!in_array($fieldName, array_keys($this->_groupValues)))
      return [];

    return $this->_groupValues[$fieldName];
  }

  /**
   * Возвращает значение атрибута
   * @param string $fieldName
   * @return mixed
   */
  public function getAttributeValue($fieldName)
  {
    if (!in_array($fieldName, array_keys($this->_groupValues)))
      return null;

    if (!property_exists($this, $fieldName))
      return null;

    if ($this->$fieldName === '' || $this->$fieldName === null)
      return null;

    if (is_array($this->$fieldName))
    {
      $result = [];
      foreach ($this->$fieldName as $field)
      {
        $field = intval($field);
        if (in_array($field, array_keys($this->_groupValues[$fieldName])))
          $result[] = $this->_groupValues[$fieldName][$field];
      }
      return $result;
    }
    else
    {
      $field = intval($this->$fieldName);
      if (!in_array($field, array_keys($this->_groupValues[$fieldName])))
        return null;

      return $this->_groupValues[$fieldName][$field];
    }
  }

  /**
   * Выполняет поиск комнат
   * @return array
   */
  public function searchRooms()
  {
    if (!$this->validate())
      return [];

    $this->_rooms = [];
    foreach ($this->makeQuery() as $row)
    {
      $room = [];
      $room['Id'] = $row['Id'];
      // Парсим атрибуты
      self::parseValues($room, $row['Attributes'], ';;', '=');
      // Парсим даты
      $this->parseDates($room, $row);
      $this->_rooms[] = $room;
    }
    return $this->_rooms;
  }

  /**
   * Парсит даты проведения
   * @param $room
   * @param $row
   * @throws \CException
   */
  private function parseDates(&$room, &$row)
  {
    $ownerIds = [];
    self::parseValues($ownerIds, $row['OwnerIds'], ',');
    $userNames = [];
    self::parseValues($userNames, $row['Names'], ';');
    $dates = [];
    self::parseValues($dates, $row['Dates'], ';');
    if (count($ownerIds) !== count($userNames) || count($ownerIds) !== count($dates))
      throw new \CException('Ошибка парсига диапазонов дат!');

    $partnerOwners = [];
    self::parseValues($partnerOwners, $row['PartnerOwners'], ';;');
    $partnerDates = [];
    self::parseValues($partnerDates, $row['PartnerDates'], ';;');

    // Парсим диапазоны дат
    $datesRanges = [];
    for ($i = 0; $i < count($dates); ++$i)
    {
      if (empty($dates[$i]))
        continue;

      $range = [];
      self::parseValues($range, $dates[$i], ',', '=');

      $minDate = min(self::$_dates); $maxDate = max(self::$_dates);
      foreach (self::$_dateRanges as $startDate => $endDate)
      {
        if ($range['DateIn'] >= $minDate && $range['DateIn'] <= $startDate && $range['DateOut'] <= $maxDate && $range['DateOut'] >= $endDate)
        {
          $datesRanges[$startDate.'-'.$endDate]['UserId'] = $ownerIds[$i];
          $datesRanges[$startDate.'-'.$endDate]['Name'] = $userNames[$i];
        }
      }
    }

    // Парсим диапазоны дат
    for ($i = 0; $i < count($partnerDates); ++$i)
    {
      if (empty($partnerDates[$i]))
        continue;

      $range = [];
      self::parseValues($range, $partnerDates[$i], ',', '=');

      $minDate = min(self::$_dates); $maxDate = max(self::$_dates);
      foreach (self::$_dateRanges as $startDate => $endDate)
      {
        if ($range['DateIn'] >= $minDate && $range['DateIn'] <= $startDate && $range['DateOut'] <= $maxDate && $range['DateOut'] >= $endDate)
        {
          if (isset($datesRanges[$startDate.'-'.$endDate]['UserId']))
            $datesRanges[$startDate.'-'.$endDate]['UserId'] .= null;
          else
            $datesRanges[$startDate.'-'.$endDate]['UserId'] = null;

          if (isset($datesRanges[$startDate.'-'.$endDate]['Name']))
            $datesRanges[$startDate.'-'.$endDate]['Name'] .= $partnerOwners[$i];
          else
            $datesRanges[$startDate.'-'.$endDate]['Name'] = $partnerOwners[$i];
        }
      }
    }
    $room['Dates'] = $datesRanges;
  }

  /**
   * Выполняет запрос комнат
   */
  private function makeQuery()
  {
    $data = [];
    $usedProductIdsSql = 'SELECT oi."ProductId" FROM "PayOrderItem" oi
                INNER JOIN "PayProduct" p ON oi."ProductId" = p."Id"
                LEFT JOIN "PayOrderItemAttribute" oia ON oia."OrderItemId" = oi."Id"
                WHERE p."EventId" = :eventId AND p."ManagerName" = \'RoomProductManager\' AND (oi."Paid" OR NOT oi."Deleted") AND
			            (oia."Name" = \'DateIn\' AND (oia."Value" < :dateIn OR oia."Value" < :dateOut)
			              OR oia."Name" = \'DateOut\' AND (oia."Value" > :dateIn OR oia."Value" > :dateOut))
                GROUP BY oi."Id"
                HAVING count("oia"."Id") = 2';

    $usedProductByPartnerIdsSql = 'SELECT prpb."ProductId" FROM "PayRoomPartnerBooking" prpb WHERE "DateIn" <= :dateIn AND "DateOut" >= :dateOut';
    if (!empty($this->DateIn) && !empty($this->DateOut))
    {
      $usedProductIdsSql  = 'products."Id" '.($this->NotFree ? '' : 'NOT') . ' IN ('.$usedProductIdsSql.') OR products."Id" IN ('.$usedProductByPartnerIdsSql.')';
      $data['dateIn'] = min($this->DateIn, $this->DateOut);
      $data['dateOut'] = max($this->DateOut, $this->DateIn);
    }
    else
      $usedProductIdsSql = '';

    $idsSubqueries = $this->makeProductIdsSubqueries();
    $idsSubqueries = empty($idsSubqueries) ? '' : 'products."Id" IN ('.$idsSubqueries.') ';

    $where = implode(' AND ', array_filter([$usedProductIdsSql, $idsSubqueries], function($v) {
          if (empty($v))
            return false;
          else
            return true;
        }));
    $where =  empty($where) ? '' : 'WHERE '.$where;

    $query = '
    WITH orders AS (
     SELECT oi."ProductId", oi."OwnerId", (COALESCE(u."LastName", \'\') || \' \' || COALESCE(u."FirstName", \'\') || \' \' || COALESCE(u."FatherName", \'\')) AS "Name", STRING_AGG(oia."Name" || \'=\' || oia."Value", \',\') AS "Dates"
         FROM "PayOrderItem" oi
         INNER JOIN "PayOrderItemAttribute" oia ON oi."Id" = oia."OrderItemId"
         INNER JOIN "User" u ON u."Id" = oi."OwnerId"
         WHERE (oi."Paid" OR NOT oi."Deleted")
         GROUP BY oi."Id", COALESCE(u."LastName", \'\') || \' \' || COALESCE(u."FirstName", \'\') || \' \' || COALESCE(u."FatherName", \'\')
    ), products AS (
	    SELECT p."Id", STRING_AGG(ppa."Name" || \'=\' || ppa."Value", \';;\') AS "Attributes" FROM "PayProduct" p
        INNER JOIN "PayProductAttribute" ppa ON p."Id" = ppa."ProductId"
        WHERE "EventId" = :eventId AND p."ManagerName" = \'RoomProductManager\'
        GROUP BY p."Id"
    )
    SELECT products."Id", products."Attributes",
        STRING_AGG(CAST(orders."OwnerId" AS TEXT), \',\') AS "OwnerIds",
        STRING_AGG(orders."Name", \';\') AS "Names",
        STRING_AGG(orders."Dates", \';\') AS "Dates",
        STRING_AGG(rpb."Owner", \';;\') AS "PartnerOwners",
        STRING_AGG(\'DateIn\' || \'=\' || rpb."DateIn" || \',\' || \'DateOut\' || \'=\' || rpb."DateOut", \';\') AS "PartnerDates"
      FROM products
      LEFT JOIN orders ON products."Id" = orders."ProductId"
      LEFT JOIN "PayRoomPartnerBooking" rpb ON rpb."ProductId" = products."Id"
      '.$where.'
      GROUP BY products."Id", products."Attributes"
      ORDER BY products."Id"';

    $data[':eventId'] = \BookingController::EventId;
    return \Yii::app()->db->createCommand($query)->query($data);
  }

  /**
   * Создает группу подзапросов запросов по продуктам
   * @param array $userAttributes Атрибуты используемые при постоении запроса
   * @return string
   */
  private function makeProductIdsSubqueries($userAttributes = [])
  {
    $queries = [];
    $usedAttributes = !empty($userAttributes) ? $userAttributes : self::$_attributeGroups;
    foreach ($usedAttributes as $field)
    {
      $val = $this->getAttributeValue($field);
      if (empty($val))
        continue;

      if (is_array($val))
      {
        $subqueries = [];
        foreach ($val as $v)
          $subqueries[] = "SELECT pp.\"ProductId\" FROM \"PayProductAttribute\" pp WHERE (pp.\"Name\" = '$field' AND pp.\"Value\" = '$v')";

        $queries[] = ' ('.implode(') UNION (', $subqueries).') ';
      }
      else
        $queries[] = "SELECT pp.\"ProductId\" FROM \"PayProductAttribute\" pp WHERE (pp.\"Name\" = '$field' AND pp.\"Value\" = '$val')";
    }

    if (empty($queries))
      return null;
    else
      return ' ('.implode(') INTERSECT (', $queries).') ';
  }

  public function attributeLabels()
  {
    return [
      'Hotel' => 'Пансионат',
      'Housing' => 'Корпус',
      'Category' => 'Категория',
      'DescriptionBasic' => 'Основные места',
      'DescriptionMore' => 'Дополнительные места',
      'PlaceBasic' => 'Число основных мест',
      'PlaceMore' => 'Число дополнительных мест',
      'PlaceTotal' => 'Мест всего',
      'RoomCount' => 'Число комнат',
      'DateIn' => 'Дата заезда',
      'DateOut' => 'Дата выезда',
      'NotFree' => 'Искать занятые'
    ];
  }

  /**
   * Возвращает даты проведения
   * @return array
   */
  public static function getDates()
  {
    return self::$_dates;
  }

  /**
   * Возвращает диапазоны дат
   * @return array
   */
  public static function getDateRanges()
  {
    return self::$_dateRanges;
  }

  /**
   * Возвращает дипазоны дат
   * @param array $dates
   * @return array
   */
  private function makeDateRanges($dates)
  {
    $ranges = [];
    for ($i = 0; $i < count($dates) - 1; ++$i)
      $ranges[$dates[$i]] = $dates[$i + 1];

    return $ranges;
  }

  /**
   * Парсит данные. Если указан $delemiter2 то каждая порция данных,
   * разделенная $delemiter1 разбивается еще с помощью $delemiter2
   * @param $data
   * @param $dataStr
   * @param string $delimiter1
   * @param string $delimiter2
   */
  private static function parseValues(&$data, $dataStr, $delimiter1 = ',', $delimiter2 = null)
  {
    foreach (explode($delimiter1, $dataStr) as $dataField)
    {
      if (!empty($delimiter2))
      {
        $nameValue = explode($delimiter2, $dataField);
        $data[$nameValue[0]] = $nameValue[1];
      }
      else
        $data[] = $dataField;
    }
  }
}