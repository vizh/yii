<?php
namespace mail\components\filter;


class Geo implements  IFilter
{
    /** @var GeoCondition[]  */
    public $positive = [];

    /** @var GeoCondition[]  */
    public $negative = [];

    /**
     * @var \CDbCriteria
     */
    private $criteria;

    public function getCriteria()
    {
        $this->criteria = new \CDbCriteria();
        $this->fillCriteria($this->positive);
        $this->fillCriteria($this->negative, false);
        return $this->criteria;
    }

    private $criteriaCount = 0;

    /**
     * @param GeoCondition[] $conditions
     * @param bool $in
     */
    private function fillCriteria($conditions, $in = true)
    {
        if (empty($conditions))
            return;

        $command = \Yii::app()->getDb()->createCommand();
        $command->select('UserId')->from('UserLinkAddress')->leftJoin('ContactAddress', '"ContactAddress"."Id" = "UserLinkAddress"."AddressId"');
        foreach ($conditions as $condition) {
            $where = '"ContactAddress"."CountryId" = :CountryId_'.$this->criteriaCount.' AND "ContactAddress"."RegionId" = :RegionId_'.$this->criteriaCount;
            $this->criteria->params['CountryId_'.$this->criteriaCount] = $condition->countryId;
            $this->criteria->params['RegionId_'.$this->criteriaCount] = $condition->regionId;
            if (!empty($condition->cityId)) {
                $where.=' AND "ContactAddress"."CityId" = :CityId_'.$this->criteriaCount;
                $this->criteria->params['CityId_'.$this->criteriaCount] = $condition->cityId;
            }
            $command->orWhere(['and', $where]);
            $this->criteriaCount++;
        }
        $this->criteria->addCondition('"t"."Id" '.(!$in ? 'NOT' : '').' IN (' . $command->getText(). ')');
    }
}