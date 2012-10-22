<?php


class FrameworkRouter
{
  private $rules = array(
    'domain' => array('partner', 'ruvents'),

    'path' => array('gii', 'mytest', 'register'),


    /*
    'path' => array('path_mask'),
    'all' => array(array('domain_name', 'path_mask'), ...)
    */
  );


  private static $instance = null;

  /**
   * @static
   * @return FrameworkRouter
   */
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
            $test = $this->checkDomain($parameter);
            break;
          case 'path':
            $test = $this->checkPath($parameter);
            break;
          case 'all':
            throw new Exception('Not implement yet');
            break;
        }
        if ($test)
        {
          return true;
        }
      }
    }

    return false;
  }

  private function checkDomain($domain)
  {
    $pattern = '/' . $domain . '/i';
    return preg_match($pattern, $_SERVER['HTTP_HOST']) === 1;
  }

  private function checkPath($path)
  {
    $pattern = '/\/' . $path . '/i';
    return preg_match($pattern, $_SERVER['REQUEST_URI']) === 1;
  }
}
