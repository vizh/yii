<?php
AutoLoader::Import('library.rocid.attachment.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.tag.*');

class Photo extends CActiveRecord implements ITagable
{
  public static $TableName = 'Mod_Photo';
  
  public static $Types = array('jpg' => 'image/jpeg', 'png' => 'image/png', 
    'gif' => 'image/gif', 'bmp' => 'image/bmp');
    
  public static $UploadFolder = '../uploads';
  
  /**
  * @param string $className
  * @return Photo
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
    return 'PhotoId';
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
      'Attachment' => array(self::BELONGS_TO, 'Attachment', 'FileId'),
      'PreviewImage' => array(self::BELONGS_TO, 'Attachment', 'ResizedFileId'),
      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
      'Users' => array(self::MANY_MANY, 'User', 'Link_User_Mod_Photo(UserId, PhotoId)')
    );
  }
  
  /**
  * Добавляет фотографии из папки self::$UploadFolder. 
  * 
  * @param int $eventId Id мероприятия, к которому относятся фотографии. 0 - общие фотографии.
  */
  public static function AddPhotos($eventId)
  {
    $path = self::$UploadFolder;    
    if($dir = @opendir($path))
    {      
      while (($f = readdir($dir)) !== false) 
      {
        if ($f > '0' and filetype($path . '/' . $f) == "file") 
        {
          $extension = strtolower(pathinfo($f, PATHINFO_EXTENSION));
          if (array_key_exists($extension, self::$Types))
          {            
            $photo = new Photo();            
            $photo->addPhotoAttachment($path, $f, $eventId);
            $photo->SetTitle('');
            $photo->SetInfo('');
            $photo->save();
          }
          unlink($path . '/' . $f);
        }
      }
      closedir($dir);      
    }
  }
  
  /**
  * put your comment there...
  * 
  * @param mixed $path
  * @param mixed $file
  * @param mixed $eventId
  */  
  private function addPhotoAttachment($path, $file, $eventId)
  {
    
    
    $fileinfo = array();
    $fileInfo['name'] = pathinfo($file, PATHINFO_BASENAME);
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $fileInfo['type'] = self::$Types[$extension];
    $stat = stat($path . '/' . $file);
    $fileInfo['size'] = $stat['size'];
    $fileInfo['tmp_name'] = $path . '/' . $file;
    $pathGetter = new PhotoAttachmentPath($eventId, $extension);
    $attachment = Attachment::CreateAttachment($fileInfo, $pathGetter);    
    $this->SetFileId($attachment->GetFileId());    
    
    $resizedFile = $this->createResizedImage($path . '/' . $file);
    
    $fileInfo['name'] = pathinfo($resizedFile, PATHINFO_BASENAME);
    $extension = strtolower(pathinfo($resizedFile, PATHINFO_EXTENSION));  
    $fileInfo['type'] = self::$Types[$extension];
    $stat = stat($path . '/' . $resizedFile);
    $fileInfo['size'] = $stat['size'];
    $fileInfo['tmp_name'] = $path . '/' . $resizedFile;
    $pathGetter = new PhotoAttachmentPath($eventId, $extension);
    $attachment = Attachment::CreateAttachment($fileInfo, $pathGetter);
    $this->SetResizedFileId($attachment->GetFileId());
    unlink($path . '/' . $resizedFile);
  }
  
  /**
  * Уменьшает заданное изображение, сохраняет и возвращает путь к измененому изображению
  * 
  * @param mixed $file Путь к изменяемому изображению
  * @param mixed $resizedName Имя нового изображения, если имя пустое - то автоматически генерируется
  * Файкладется в тот же каталог, где лежит исходное изображение
  * @return string|null Имя уменьшенного файла
  */
  private function createResizedImage($file, $resizedName = '')
  {
    if (empty($resizedName))
    {
      $name = pathinfo($file, PATHINFO_FILENAME);      
      $resizedName = $name . '_resized' . '.jpg';
    }
    $path = pathinfo($file, PATHINFO_DIRNAME);
    
    list($width, $height, $type, $attr) = @getimagesize($file);
    
    
    if ($type === 1) //Gif
    {
      $image = imagecreatefromgif($file);
    }
    elseif ($type === 2) //Jpeg
    {
      $image = imagecreatefromjpeg($file);
    }
    elseif ($type === 3) //Png
    {
      $image = imagecreatefrompng($file);
    }
    else
    {
      $image = @imagecreatefromwbmp($file);
      if (!$image)
      {
        return null;
      }
    }
    
    $newWidth = 200;
    $newHeight = $height * $newWidth / $width;
    
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
    imagejpeg($newImage, $path . '/' . $resizedName);
    return $resizedName;
    
  }
  
  /**
  * Возвращает несколько случайных фотографий из последних загруженных
  * 
  * @param int $number Количество возвращаемых фотографий
  * @param array[int] $events Список мероприятий, среди которых выбираются фотографии. Если массив пустой - то среди всех мероприятий.
  * @param int $range Rоличество последних фотографий, среди которых производится случайная выборка. Если значение на задано, то определяется настройками модуля.
  * @return array[Photo]
  */
  public static function GetRandomPhotos($number, $events, $range = 0)
  {
    //SELECT * FROM Table ORDER BY RAND() LIMIT 10;
    $model = Photo::model();
    $criteria = new CDbCriteria();
    if (! empty($events))
    {
      $criteria->condition = 'EventId IN (' . implode(',', $events) . ')';
    }
    if ($range === 0 || empty($range))
    {      
      $criteria->order = 'RAND()';
      $criteria->limit = $number;
      $photos = $model->with('Attachment', 'PreviewImage')->findAll($criteria);
    }
    else
    {      
      $criteria->limit = $range;
      $photos = $model->AddRelationOrder('Attachment', '??.CreationTime DESC')
        ->with('Attachment', 'PreviewImage')->together()->findAll($criteria);
      $randKeys = array_rand($photos, $number);
      $temp = array();
      foreach ($randKeys as $key)
      {
        $temp[] = $photos[$key];
      }
      $photos = $temp;
    }    
    return $photos;
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetPhotoId()
  {
    return $this->PhotoId;
  }
  
  //FileId
  public function GetFileId()
  {
    return $this->FileId;
  }
  
  public function SetFileId($value)
  {
    $this->FileId = $value;
  }
  
  //ResizedFileId
  public function GetResizedFileId()
  {
    return $this->ResizedFileId;
  }
  
  public function SetResizedFileId($value)
  {
    $this->ResizedFileId = $value;
  }
  
  //EventId
  public function GetEventId()
  {
    return $this->EventId;
  }
  
  public function SetEventId($value)
  {
    $this->EventId = $value;
  }
  
  //Title
  public function GetTitle()
  {
    return $this->Title;
  }
  
  public function SetTitle($value)
  {
    $this->Title = $value;
  }
  
  //Info
  public function GetInfo()
  {
    return $this->Info;
  }
  
  public function SetInfo($value)
  {
    $this->Info = $value;
  }  
  
/**
* ITagable Members
*/
  public function GetContentType()
  {
    return 'Photo';
  }
  
  public function GetContentId()
  {
    return $this->GetPhotoId();
  }
}