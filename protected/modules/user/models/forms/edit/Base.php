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
}
