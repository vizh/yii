<?php
namespace pay\models;

class AdditionalAttribute
{
    const TypeText = 'text';
    const TypeTextarea = 'textarea';
    const TypeBoolean = 'boolean';

    public $Name;
    public $Type = self::TypeText;
    public $Order = 0;
    public $Label;

    public static function getTypes()
    {
        return [
            self::TypeText,
            self::TypeTextarea,
            self::TypeBoolean
        ];
    }
}