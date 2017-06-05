<?php
namespace event\models\forms;

class EventListFilterForm extends \CFormModel
{
    public $City;
    public $Type;
    public $Query;

    public function rules()
    {
        return [
            ['City, Type, Query', 'safe']
        ];
    }

    /**
     * Возвращает список дотспуных городов мероприятий
     * @param int $month
     * @param int $year
     * @return string[]
     */
    public function getCityList($month, $year)
    {
        $cityList = [
            \Yii::t('app', 'Все города')
        ];
        $cityIdList = [];
        $criteria = new \CDbCriteria();
        $criteria->with = ['LinkAddress'];
        /** @var $events \event\models\Event[] */
        $events = \event\models\Event::model()->byDate($year, $month)->byVisible()->findAll($criteria);
        foreach ($events as $event) {
            if ($event->getContactAddress() !== null) {
                $cityIdList[] = $event->getContactAddress()->CityId;
            }
        }

        if (!empty($cityIdList)) {
            $criteria = new \CDbCriteria();
            $criteria->order = '"t"."Priority" DESC, "t"."Name" ASC';
            $criteria->addInCondition('"t"."Id"', $cityIdList);
            $cities = \geo\models\City::model()->findAll($criteria);
            foreach ($cities as $city) {
                $cityList[$city->Id] = $city->Name;
            }
        }
        return $cityList;
    }

    /**
     * Возвращает список доступных типов мероприятий
     * @param int $month
     * @param int $year
     * @return string[]
     */
    public function getTypeList($month, $year)
    {
        $typeList = [
            \Yii::t('app', 'Все категории')
        ];
        $criteria = new \CDbCriteria();
        $criteria->with = ['Type'];
        $criteria->order = '"Type"."Priority" DESC';
        $events = \event\models\Event::model()->byDate($year, $month)->byVisible()->findAll($criteria);
        foreach ($events as $event) {
            if ($event->Type !== null
                && !isset($typeList[$event->Type->Id])
            ) {
                $typeList[$event->Type->Id] = $event->Type->Title;
            }
        }
        return $typeList;
    }
}
