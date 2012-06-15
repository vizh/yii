<?php
class XmlSerializer
{
  
  private static $xmlBase = "<?xml version='1.0'  encoding='utf-8'?>\n<root></root>";
  
  const ArrayName = 'Array';
  const ClassAttr = 'class';
  const NumericTag = 'numeric';
  const NumericAttr = 'key';
  /**
  * На входе объект для сериализации, на выходе - корректный xml документ
  * 
  * @param mixed $object
  * @return SimpleXMLElement
  */
  public static function Serialize($object)
  {
    if (self::isSimple($object))
    {
      throw new Exception('Simple Type cannot serialized');
    }
    $xml = new SimpleXMLElement(self::$xmlBase);
    self::parseObject($xml, $object);
    return $xml;
  }
  
  /**
  * Рекурсивно вызываемый метод
  * 
  * @param SimpleXMLElement $xmlPart
  * @param mixed $object
  */
  private static function parseObject($xmlPart, $object)
  {
    if (is_object($object))
    {
      $xmlPart->addAttribute(self::ClassAttr, get_class($object));
      foreach ($object as $key => $value)
      {
        if (self::isSimple($value))
        {
          $xmlPart->addChild($key, $value);
        }
        else
        {
          $child = $xmlPart->addChild($key);
          self::parseObject($child, $value);
        }        
      }
    }
    else if (is_array($object))
    {
      $xmlPart->addAttribute(self::ClassAttr, self::ArrayName);
      foreach ($object as $key => $value)
      {        
        if (is_numeric($key))
        {
          $tag = self::NumericTag;
        }
        else
        {
          $tag = $key;
        }
        if (self::isSimple($value))
        {
          $child = $xmlPart->addChild($tag, $value);
        }
        else
        {
          $child = $xmlPart->addChild($tag);
        }
        if (is_numeric($key))
        {
          $child->addAttribute(self::NumericAttr, $key);
        }
        self::parseObject($child, $value);
      }
    }
  }
  
  private static function isSimple($object)
  {
    if (is_object($object) || is_array($object))
    {
      return false;
    }
    return true;
  }
  
  /**
  * put your comment there...
  * 
  * @param SimpleXMLElement $xml
  * @return mixed
  */
  public static function Deserialize($xml)
  {
    return self::parseXml($xml);
  }
  
  /**
  * put your comment there...
  * 
  * @param SimpleXMLElement $xml
  * @return mixed
  */
  private static function parseXml($xml)
  {
    if (isset($xml[self::ClassAttr]))
    {      
      $class = (string) $xml[self::ClassAttr];      
      if ($class == self::ArrayName)
      {
        $obj = Array();
        foreach($xml->children() as $key => $child)
        {          
          $arrKey = (string) $key;
          if (isset($child[self::NumericAttr]))
          {
            $arrKey = (string) $child[self::NumericAttr];
          }
          $obj[$arrKey] = self::parseXml($child);
        }
      }
      else
      {        
        $reflection = new ReflectionClass($class);        
        $obj = $reflection->newInstance();        
        foreach ($xml->children() as $key => $child)
        {          
          $obj->$key = self::parseXml($child);
        }
      }
      return $obj;
    }
    else
    {
      return (string)$xml;
    }
  }
}