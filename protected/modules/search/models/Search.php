<?php
namespace search\models;

class Search
{
    protected $_models = [];

    public function appendModel(\search\components\interfaces\ISearch $model)
    {
        $this->_models[get_class($model)] = $model;

        return $this;
    }

    public function findAll($term, $locale = null)
    {
        $result = new \stdClass();
        foreach ($this->_models as $class => $model) {
            $criteria = $model->bySearch($term, $locale)->getDbCriteria();
            $offset = $criteria->offset;
            $limit = $criteria->limit;
            $criteria->offset = null;
            $criteria->limit = null;

            $result->Counts[$class] = $model->count($criteria);
            if ($result->Counts[$class] > 0) {
                if ($offset !== null || $limit !== null) {
                    $criteria->limit = $limit;
                    $criteria->offset = $offset;
                }
                $result->Results[$class] = $model->findAll($criteria);
            }
        }

        return $result;
    }
}
