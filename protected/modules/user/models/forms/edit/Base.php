<?php
namespace user\models\forms\edit;
abstract class Base extends \CFormModel
{
  public function filterPurify($value) 
  {
    $purifier = new \CHtmlPurifier();
    $purifier->options = array(
      'HTML.AllowedElements'   => array(),
      'HTML.AllowedAttributes' => array(), 
    );
    return $purifier->purify($value);
  }
  
  public function filterArrayPurify($value) 
  {
    $purifier = new \CHtmlPurifier();
    $purifier->options = array(
      'HTML.AllowedElements'   => array(),
      'HTML.AllowedAttributes' => array(), 
    );
    $result = array();
    foreach ($value as $key => $val)
    {
      $result[$key] = is_array($val) ? $this->filterArrayPurify($val) : $purifier->purify($val);
    }
    return $result;
  }
}
