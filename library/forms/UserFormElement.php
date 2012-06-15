<?php
  
class UserFormElement
{
  private $id;
  private $name;
  
  private $validators = array();
  private $errors = array();
  
  public function __construct($name, $id = '')
  {
    $this->id = $id;
    $this->name = $name;
  }
  
  public function GetName()
  {
    return $this->name;
  }
  
  public function GetErrors()
  {
    return $this->errors;
  }
  
  /**
  * Добавляет валидатор
  * 
  * @param string $name
  * @param mixed $options
  */
  public function AddValidator($name, $options = '')
  {
    $this->validators[$name] = $options;   
  }
  
  
  /**
  * Добавляет список валидаторов
  * 
  * @param array $list
  */
  public function AddValidators($list)
  {
    if (is_array($list))
    {
      foreach ($list as $key => $options)
      {
        if (is_numeric($key))
        {
          $this->AddValidator($options);
        }
        else
        {
          $this->AddValidator($key, $options);
        }
      }
    }
  }
  
  public function Validate()
  {
    $flag = true;
    
    foreach ($this->validators as $name => $options)
    {
      if (method_exists($this, $name))
      {
        $flag = $this->$name($options) ? $flag : false;
      }
      elseif (class_exists($name))
      {
        
      }
    }
    
    return $flag;
  }
  
  public function Requirement()
  {
    $var = Registry::GetRequestVar($this->name);    
    if (is_null($var))
    {
      $this->errors[] = 'Requirement';
      return false;
    }
    
    return true;
  }
  
  public function NotEmpty()
  {
    $var = trim(Registry::GetRequestVar($this->name));
    if (empty($var))
    {
      $this->errors[] = 'NotEmpty';
      return false;
    }
    
    return true;
  }
  
  public function MinLength($option)
  {
    $var = Registry::GetRequestVar($this->name);
    if (empty($var) || strlen($var) < $option)
    {
      $this->errors[] = 'MinLength';
      return false;
    }
    
    return true;
  }  
  
  public function MaxLength($option)
  {
    $var = Registry::GetRequestVar($this->name);
    if (empty($var) || strlen($var) > $option)
    {
      $this->errors[] = 'MaxLength';
      return false;
    }
    
    return true;
  }
  
  public function Email()
  {
    $var = Registry::GetRequestVar($this->name);    
    $var = filter_var($var, FILTER_VALIDATE_EMAIL);
    if ($var == false)
    {
      $this->errors[] = 'Email';
      return false;
    }
    
    return true;
  }
}