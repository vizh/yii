<?php
namespace mail\components\filter;

class RunetId implements IFilter
{
    /** @var EmailCondition[] */
    public $positive = [];

    /** @var EmailCondition[] */
    public $negative = [];

    public function getCriteria()
    {
        $criteria = new \CDbCriteria();
        if (!empty($this->positive)) {
            $runetIdList = [];
            foreach ($this->positive as $condition) {
                $runetIdList = array_merge($runetIdList, $condition->runetIdList);
            }
            $criteria->addInCondition('"t"."RunetId"', $runetIdList);
        }

        if (!empty($this->negative)) {
            $runetIdList = [];
            foreach ($this->negative as $condition) {
                $runetIdList = array_merge($runetIdList, $condition->runetIdList);
            }
            $criteria->addNotInCondition('"t"."RunetId"', $runetIdList);
        }

        return $criteria;
    }
} 