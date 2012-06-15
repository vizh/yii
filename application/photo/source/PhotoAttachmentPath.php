<?php
class PhotoAttachmentPath implements IAttachmentPath
{
  private static $basePath = '/files/photo/events';
  
  private $eventId;
  private $extension;
  
  public function __construct($eventId, $extension = 'jpg')
  {
    $this->eventId = $eventId;
    $this->extension = $extension;
  }
  
  public function GetPath($hash)
  {    
    return '.' . $this->GetUrl($hash);
  }
  
  public function GetUrl($hash)
  {
    return self::$basePath . '/' . $this->eventId . '/' . $hash . '.' . $this->extension;
  }
}
