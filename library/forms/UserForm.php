<?php


class UserForm
{
  private $id;
  private $elements = array();
  
  public function __construct($id)
  {
    if (empty($id))
    {
      throw new Exception('Id формы не может быть пустым.');
    }
    $this->id = $id;
  }
  
  private $opened = false;
  
  /**
  * Возвращает тег формы, помечает флаг, что форма открыта
  * 
  * @param mixed $attributes
  * 
  * @return string
  */
  public function Open($attributes = array())
  {
    if ($this->opened)
    {
      return '';
    }
    
    $this->opened = true;
    
    $action = Lib::ArrayValueI('action', $attributes, '');
    $method = Lib::ArrayValueI('method', $attributes, 'post');
    $enctype = Lib::ArrayValueI('enctype', $attributes, '');
    $target = Lib::ArrayValueI('target', $attributes, '');
    $name = Lib::ArrayValueI('name', $attributes, '');    
    
    if (empty($name))
    {
      $name = $this->id;
    }
    
    $return = '<form';
    
    $return .= ' ' . 'id="' . $this->id . '"';
    
    if (!empty($name))
    {
      $return .= ' ' . 'name="' . $name . '"';
    }
    
    $return .= ' ' . 'action="' . $action . '"';
    $return .= ' ' . 'method="' . $method . '"';
    
    if (! empty($enctype))
    {
      $return .= ' ' . 'enctype="' . $enctype . '"';
    }
    
    if (! empty($target))
    {
      $return .= ' ' . 'target="' . $target . '"';
    }
    
    $return .= self::AttributesToString($attributes);
    $return .= '>' . "\n";
    
    $return .= '<input type="hidden" name="' . $this->id .'" value="1">';
    
    return $return;
  }
  
  public function Close()
  {
    if (! $this->opened)
    {
      return '';
    }
    $this->opened = false;
    
    return "\n</form>";
  }
  
  public function GetFormId()
  {
    return $this->id;
  }
  
  /**
  * Возвращает 
  * 
  * @return bool
  */
  public function IsRequest()
  {
    $var = Registry::GetRequestVar($this->id);
    if (! empty($var))
    {
      return true;
    }
    
    return false;
  }
  
  /**
  * Возвращает все значения формы
  * 
  */
  public function GetValues()
  {
    $result = array();
    foreach ($this->elements as $element)
    {
      $var = Registry::GetRequestVar($element->GetName());
      if ($var != null)
      {
        $result[$element->GetName()] = $var;
      }      
    }
    return $result;
  }
  
  public function GetValue($name)
  {
    return trim(Registry::GetRequestVar($name));
  }
  
  public function GetErrors($name)
  {
    if (array_key_exists($name, $this->elements))
    {
      return $this->elements[$name]->GetErrors();
    }
    else
    {
      throw new Exception('Элемент с именем ' . $name . ' не найден');
    }
  }
  
  /**
  * Проверяет валидность введенных значений формы
  * 
  */
  public function Validate()
  {
    $flag = true;
    
    foreach ($this->elements as $element)
    {
      if (! $element->Validate())
      {
        $flag = false;
      }
    }
    
    return $flag;
  }
  
  /**
  * Добавляет элемент на форму
  * 
  * @param UserFormElement $element
  */
  public function AddElement(UserFormElement $element)
  {
    $this->elements[$element->GetName()] = $element;
  }
  
  /**
  * Добавляет элементы на форму
  * 
  * @param array[UserFormElement] $elements
  */
  public function AddElements($elements)
  {
    foreach($elements as $element)
    {
      $this->AddElement($element);
    }
  }
  
  /**
  * Удаляет элемент с формы
  * 
  * @param string $name
  */
  public function RemoveElement($name)
  {
    if (isset($this->elements[$name]))
    {
      unset($this->elements[$name]);
    }
  }
  
  /**
  * Возвращает строку аттрибута с классом контрола или классом ошибки контрола
  * 
  * @param string $name
  * @param array $attributes
  * 
  * @return string
  */
  private function getClassOrClassError($name, $attributes = array())
  {    
    $return = '';
    if (array_key_exists($name, $this->elements))
    {
      $errors = $this->elements[$name]->GetErrors();
      if (isset($attributes['classerror']) && !empty($errors))
      {
        $return = ' ' . 'class="' . $attributes['classerror'] . '" ';
      }
      else if (isset($attributes['class']))
      {
        $return = ' ' . 'class="' . $attributes['class'] . '" ';
      }
    }
    
    return $return;
  }
  
  /**
  * Возвращает строку созданного текстового поля
  * 
  * @param string $name
  * @param array $attributes
  * 
  * @return string
  */
  public function TextBox($name, $attributes = array())
  {
    $return = '<input type="text"';
    
    if (array_key_exists($name, $this->elements))
    {
      $value = Registry::GetRequestVar($name) == null ? Lib::ArrayValueI('value', $attributes, '') 
        : Registry::GetRequestVar($name);
      $id = Lib::ArrayValueI('id', $attributes, '');
      
      if (!empty($id))
      {
        $return .= ' ' . 'id="' . $id . '"';
      }
      
      $return .= ' ' . 'name="' . $name . '"';
      
      if (!empty($value))
      {
        $return .= ' ' . 'value="' . htmlspecialchars($value) . '"';
      }
      
      $return .= $this->getClassOrClassError($name, $attributes);
      $return .= self::AttributesToString($attributes) . '>';
      
      return $return;
    }
    
    throw new Exception('Не обнаружен элемент с таким именем');    
  }
  
  /**
  * Возвращает строку созданного поля для ввода пароля
  * 
  * @param string $name
  * @param array $attributes
  * 
  * @return string
  */
  public function Password($name, $attributes = array())
  {
    $return = '<input type="password"';
    
    if (array_key_exists($name, $this->elements))
    {      
      $id = Lib::ArrayValueI('id', $attributes, '');
      
      if (!empty($id))
      {
        $return .= ' ' . 'id="' . $id . '"';
      }
      
      $return .= ' ' . 'name="' . $name . '"';
      
      $return .= $this->getClassOrClassError($name, $attributes);
      $return .= self::AttributesToString($attributes) . '>';
      
      return $return;
    }
    
    throw new Exception('Не обнаружен элемент с таким именем');  
  }
  
  /**
  * Возвращает строку созданного текстового поля
  * 
  * @param string $name
  * @param array $attributes
  * 
  * @return string
  */
  public function Checkbox($name, $value, $attributes = array())
  {
    $return = '<input type="checkbox"';
    
    if (array_key_exists($name, $this->elements))
    {
      $vals = Registry::GetRequestVar($name);
      $checked = $vals != null && in_array($value, $vals);
        
      $id = Lib::ArrayValueI('id', $attributes, '');
      
      if (!empty($id))
      {
        $return .= ' ' . 'id="' . $id . '"';
      }
      
      $return .= ' ' . 'name="' . $name . '[]"';
      $return .= ' ' . 'value="' . $value . '"';
      
      if ($checked)
      {
        $return .= ' ' . 'checked="checked"';
      }
      
      $return .= $this->getClassOrClassError($name, $attributes);
      $return .= self::AttributesToString($attributes) . '>';
      
      return $return;
    }
    
    throw new Exception('Не обнаружен элемент с таким именем');    
  }
  
  /**
  * Возвращает строку созданной кнопки отправки формы
  * 
  * @param string $name
  * @param array $attributes
  * 
  * @return string
  */
  public function Submit($name, $attributes = array())
  {
    $return = '<input type="submit"';
    
    if (array_key_exists($name, $this->elements))
    {
      $value = Lib::ArrayValueI('value', $attributes, '');
      $id = Lib::ArrayValueI('id', $attributes, '');
      
      if (!empty($id))
      {
        $return .= ' ' . 'id="' . $id . '"';
      }
      
      $return .= ' ' . 'name="' . $name . '"';
      
      if (!empty($value))
      {
        $return .= ' ' . 'value="' . $value . '"';
      }
      
      $return .= $this->getClassOrClassError($name, $attributes);
      $return .= self::AttributesToString($attributes) . '>';
      
      return $return;
    }
    
    throw new Exception('Не обнаружен элемент с таким именем');    
  }
  
  /**
  * Возвращает строку созданной кнопки на основе изображения
  * 
  * @param string $name
  * @param string $src
  * @param array $attributes
  * 
  * @return string
  */
  public function Image($name, $src, $attributes = array())
  {
    $return = '<input type="image"';
    
    if (array_key_exists($name, $this->elements))
    {
      $value = Lib::ArrayValueI('value', $attributes, '');
      $id = Lib::ArrayValueI('id', $attributes, '');
      
      if (!empty($id))
      {
        $return .= ' ' . 'id="' . $id . '"';
      }
      
      $return .= ' ' . 'name="' . $name . '"';
      $return .= ' ' . 'src="' . $src . '"';
      
      if (!empty($value))
      {
        $return .= ' ' . 'value="' . $value . '"';
      }
      
      $return .= $this->getClassOrClassError($name, $attributes);
      $return .= self::AttributesToString($attributes) . '>';
      
      return $return;
    }
    
    throw new Exception('Не обнаружен элемент с таким именем');    
  }
  
  /**
  * Возвращает строку созданного поля для ввода многострочных текстов
  * 
  * @param string $name
  * @param array $attributes
  * 
  * @return string
  */
  public function TextArea($name, $attributes = array())
  {
    throw new Exception('Not implement yet.');
  }
  
  /**
  * Возвращает строку радио баттона
  * 
  * @param string $name
  * @param array $attributes
  * 
  * @return string
  */
  public function Radio($name, $attributes = array())
  {
    throw new Exception('Not implement yet.');
  }
  
  /**
  * Преобразует ассоциативный массив аттрибутов в строку - имя_параметра1="значение1" имя_параметра2="значение2" ...
  * 
  * @param mixed $array
  * 
  * @return string
  */
  public static function AttributesToString($attributes)
  {
    $return = '';
    if (is_array($attributes))
    {
      foreach ($attributes as $key => $value)
      {
        if (!in_array(strtolower($key), array('id', 'name', 'action', 'method', 'target', 'enctype', 
          'type', 'value', 'class', 'classerror')))
        {
          $return .= ' ' . $key . '="' . $value . '"';
        }        
      }
    }
    
    return $return;
  }
}
