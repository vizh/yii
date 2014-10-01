<?php
namespace mail\components\filter;

class GeoCondition
{

    public $label;
    public $countryId;
    public $regionId;
    public $cityId;

    function __construct($label, $countryId, $regionId, $cityId = null)
    {
        $this->label = $label;
        $this->countryId = $countryId;
        $this->regionId = $regionId;
        $this->cityId = $cityId;
    }
} 