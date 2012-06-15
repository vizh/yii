<?php
AutoLoader::Import('library.rocid.attachment.*');

/**
* Для отдачи закрытых файлов разобраться с nginx или mod_xsendfile для Apache
*/

class Attachment extends CActiveRecord implements ISettingable
{
  /**
  * Возвращает массив вида:
  * array('name1'=>array('DefaultValue', 'Description'), 
  *       'name2'=>array('DefaultValue', 'Description'), ...)
  */
  public function GetSettingList()
  {
    return array('MaxFileSize' => array(2048000, 'Максимальный размер загружаемого аттачмента'),
      'SavePath' => array('../files', 'Путь к сохраняемым аттачментам'));
  }
  public static $TableName = 'Core_Attachment';
  
  /**
  * @param string $className
  * @return User
  */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return self::$TableName;
  }
  
  public function primaryKey()
  {
    return 'FileId';
  }
  
  public function relations()
  {
    return array(
    //      'Addresses' => array(self::MANY_MANY, 'ContactAddress', 'Link_User_ContactAddress(UserId, AddressId)',
//        'with' => array('City')),
//      'Phones' => array(self::MANY_MANY, 'ContactPhone', 'Link_User_ContactPhone(UserId, PhoneId)'),
//      'ServiceAccounts' => array(self::MANY_MANY, 'ContactServiceAccount', 'Link_User_ContactServiceAccount(UserId, ServiceId)',
//        'with' => array('ServiceType')),
//      'Sites' => array(self::MANY_MANY, 'ContactSite', 'Link_User_ContactSite(UserId, SiteId)'),                
    );
  }
  
  /**
  * Создает объект класса Attachment. Сохраняет файл с информацией $fileInfo. 
  * Возвращает обект класса Attachment.
  * Для предзагруженных файлов указывается $fileInfo['SavePath']
  * 
  * @param array $fileInfo
  * @param IAttachmentPath $pathGetter
  * @return Attachment
  */
  public static function CreateAttachment($fileInfo, $pathGetter = null)
  {
    if (! $pathGetter)
    {
      $pathGetter = new DefaultAttachmentPath();
    }
    
    $attachment = new Attachment();
    $attachment->SetName($fileInfo['name']);
    $attachment->SetType($fileInfo['type']);
    $attachment->SetSize($fileInfo['size']);    

    $hash = Lib::GetUniqueId();
    $attachment->SetHash($hash);
    $savePath = $pathGetter->GetPath($hash);
    self::createPath($savePath);
    copy($fileInfo['tmp_name'], $savePath);
    chmod($savePath, 0666);

    $attachment->SetCreationTime(time());
    $attachment->save();
    
    return $attachment;
  }
  
  private static function createPath($path)
  {
    echo $path . '<br/>';
    $path = pathinfo($path, PATHINFO_DIRNAME);
    if (! file_exists($path))
    {
      echo '! exist ' . $path . '<br/>';
      $parts = split('/', $path);
      $i = 0;
      $temp = '';
      if ($parts[0] === '.' || $parts[0] === '..')
      {
        $i = 1;
        $temp = $parts[0];
      }      
      //проверить по частям существование директории, все недостающие кусочки создать
      for (; $i < sizeof($parts); $i++)
      {
        $temp .= '/' . $parts[$i];
        echo '! try create ' . $temp . '<br/>';
        if (! file_exists($temp))
        {
          mkdir($temp, 0666);
        }
      }
    }
  }
  
  public function GetAttachmentContent()
  {
    return file_get_contents($this->GetUrl());
  }
  
  public function GetAttachmentContentWithHeader()
  {
    return $this->__toString();
  }
  
  public function __toString()
  {
    // Получение содержимого файла
    $fileData = file_get_contents($this->GetUrl());
    // Установление заголовков
    header('Cache-control: max-age=31536000');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $this->GetCreationTime()) . ' GMT');
    header('Content-disposition: inline; filename="' . $this->GetName() . '"');
    header('Content-Length: ' . $this->GetSize());
    header('Content-type: ' . $this->GetType());
    // Отдаем файл
    print $fileData;
  }
  
  public function RemoveAttachment()
  {
    unlink($this->GetUrl());
    $this->delete();
  }
  
  public function GetFilePath()
  {
    $url = $this->GetUrl();
    if (substr($url, 0, 1) === '.')
    {
      return $url;
    }
    else
    {
      $url = '.' . ( substr($url, 0, 1) === '/' ? '' : '/') . $url;
      return $url;
    }     
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetFileId()
  {
    return $this->FileId;
  }
  
  //Name
  public function GetName()
  {
    return $this->Name;
  }
  
  public function SetName($value)
  {
    $this->Name = $value;
  }
  
  //Type
  public function GetType()
  {
    return $this->Type;
  }
  
  public function SetType($value)
  {
    $this->Type = $value;
  }
  
  //Size
  public function GetSize()
  {
    return $this->Size;
  }
  
  public function SetSize($value)
  {
    $this->Size = $value;
  }
  
  //Hash
  public function GetHash()
  {
    return $this->Hash;
  }
  
  public function SetHash($value)
  {
    $this->Hash = $value;
  }
  
  //Url
  public function GetUrl()
  {
    return $this->Url;
  }  
  
  public function SetUrl($value)
  {
    $this->Url = $value;
  }
  
  //Counter
  public function GetCounter()
  {
    return $this->Counter;
  }  
  
  public function SetCounter($value)
  {
    $this->Counter = $value;
  }
  
  //CreationTime
  public function GetCreationTime()
  {
    return $this->CreationTime;
  }  
  
  public function SetCreationTime($value)
  {
    $this->CreationTime = $value;
  }
}
