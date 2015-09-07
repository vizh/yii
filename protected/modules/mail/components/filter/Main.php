<?php
namespace mail\components\filter;

class Main implements IFilter
{
    private $filters = [];

    public function getFilters()
    {
        return $this->filters;
    }

    public function addCondition($class, $condition, $positive = true)
    {
        if (!array_key_exists($class, $this->filters)) {
            $this->filters[$class] = new $class();
        }
        $this->filters[$class]->{$positive ? 'positive' : 'negative'}[] = $condition;
    }

    public function getCriteria()
    {
        $criteria = new \CDbCriteria();
        foreach ($this->getFilters() as $filter) {
            $operator = 'OR';
            if (sizeof($filter->negative) == 1 && empty($filter->positive)) {
                $operator = 'AND';
            }
            $criteria->mergeWith($filter->getCriteria(), $operator);
        }
        return $criteria;
    }
} 