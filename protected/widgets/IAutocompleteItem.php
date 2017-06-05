<?php
namespace application\widgets;

interface IAutocompleteItem
{
    /**
     * @param mixed $value
     *
     * @return \CActiveRecord
     */
    public function byAutocompleteValue($value);

    /**
     * @return string
     */
    public function getAutocompleteData();
}