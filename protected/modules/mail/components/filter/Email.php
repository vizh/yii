<?php
namespace mail\components\filter;

class Email implements IFilter
{
    /** @var EmailCondition[] */
    public $positive = [];

    /** @var EmailCondition[] */
    public $negative = [];

    public function getCriteria()
    {
        $criteria = new \CDbCriteria();
        if (!empty($this->positive)) {
            $emails = [];
            foreach ($this->positive as $condition) {
                $emails = array_merge($emails, $condition->emails);
            }
            $criteria->addInCondition('"t"."Email"', $emails);
        }

        if (!empty($this->negative)) {
            $emails = [];
            foreach ($this->negative as $condition) {
                $emails = array_merge($emails, $condition->emails);
            }
            $criteria->addNotInCondition('"t"."Email"', $emails);
        }

        return $criteria;
    }
} 