<?php


class FrameworkRouter
{
  private $rules = array(
    'domain' => array('partner'),

    /*
    'path' => array('path_mask'),
    'all' => array(array('domain_name', 'path_mask'), ...)
    */
  );


  private static $instance = null;
  public static function Instance()
  {
    if (self::$instance == null)
    {
      self::$instance = new FrameworkRouter();
    }

    return self::$instance;
  }


  public function IsOnlyYiiFramework()
  {
    foreach ($this->rules as $key => $values)
    {
      foreach ($values as $parameter)
      {
        $test = false;
        switch ($key)
        {
          case 'domain':
            break;
          case 'path':
            break;
          case 'all':
            break;
        }
      }
    }
  }

  private function checkDomain($domain)
  {

  }
}
