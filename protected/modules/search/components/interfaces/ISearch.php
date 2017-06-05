<?php
namespace search\components\interfaces;

interface ISearch
{
    /**
     *
     * @param string $term
     * @param string $locale
     * @param bool $useAnd
     * @return \CDbCriteria
     */
    public function bySearch($term, $locale = null, $useAnd = true);
}
