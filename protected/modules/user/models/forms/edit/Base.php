<?php
namespace user\models\forms\edit;

abstract class Base extends \CFormModel
{
    public function filterPurify($value)
    {
        $purifier = new \CHtmlPurifier();
        $purifier->options = [
            'HTML.AllowedElements' => [],
            'HTML.AllowedAttributes' => [],
        ];
        return $purifier->purify($value);
    }

    public function filterArrayPurify($value)
    {
        $purifier = new \CHtmlPurifier();
        $purifier->options = [
            'HTML.AllowedElements' => [],
            'HTML.AllowedAttributes' => [],
        ];
        $result = [];
        foreach ($value as $key => $val) {
            $result[$key] = is_array($val) ? $this->filterArrayPurify($val) : $purifier->purify($val);
        }
        return $result;
    }
}
