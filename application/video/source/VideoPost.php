<?php
AutoLoader::Import('library.texts.*');
AutoLoader::Import('library.graphics.*');

/**
 * @property int $VideoPostId
 * @property string $Title
 * @property string $Name
 * @property string $Link
 * @property string $LinkHash
 * @property string $Status
 * @property string $Description
 * @property string $PostDate
 */
class VideoPost extends CActiveRecord
{
  public static $TableName = 'Mod_VideoPost';

  const StatusAny = 'any';
  const StatusPublish = 'publish';
  const StatusModerate = 'moderate';
  const StatusDraft = 'draft';

  /**
  * @param string $className
  * @return NewsPost
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
    return 'VideoPostId';
  }

  public function relations()
  {
    return array(
      //'Comments' => array(self::HAS_MANY, 'NewsComment', 'NewsId'),
      //'Company' => array(self::BELONGS_TO, 'Company', 'CompanyId'),
      //'Event' => array(self::BELONGS_TO, 'Event', 'EventId')
    );
  }

  public static function UploadVideo()
  {
    $path = AutoLoader::ModulesPath() . DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR . 'source' .
        DIRECTORY_SEPARATOR . 'Zend' . DIRECTORY_SEPARATOR . 'Loader.php';
    include_once $path;
    Zend_Loader::loadClass('Zend_Gdata_YouTube');

    $yt = new Zend_Gdata_YouTube();

    /** @var Zend_Gdata_YouTube_VideoQuery $query  */
    $query = $yt->newVideoQuery();
    $query->setAuthor('rocid');
    $query->setOrderBy('published');
    $query->setMaxResults(50);
    $videoFeed = $yt->getVideoFeed($query);

    /** @var Zend_Gdata_App_Entry $videoEntry */
    foreach ($videoFeed as $videoEntry)
    {
      $link = self::ClearLink($videoEntry->getFlashPlayerUrl());
      $video = self::GetVideoByLink($link);
      if ($video == null)
      {
        $video = new VideoPost();
        $video->PostDate = date('Y-m-d H:i:s', strtotime($videoEntry->getPublished()));
        $video->Title = $videoEntry->getVideoTitle();
        $video->Name = Texts::CyrToLatTitle($video->Title);
        $video->Description = $videoEntry->getVideoDescription();
        $video->SetLink($link);
        $video->Status = VideoPost::StatusPublish;
        $video->save();

        $videoThumbnails = $videoEntry->getVideoThumbnails();
        if (! empty($videoThumbnails[0]))
        {
          $image = file_get_contents($videoThumbnails[0]['url']);
          if ($image)
          {
            $tmpName = DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR .
                       md5('video' . microtime()) . '.jpg';
            file_put_contents($tmpName, $image);

            $path = $video->GetThumbnailsDir(true);
            if (! is_dir($path))
            {
              mkdir($path);
            }
            $namePrefix = $video->VideoPostId;
            $clearSaveTo = $path . $namePrefix . '_clear.jpg';
            //Graphics::SaveImageFromPost('tape_image', $clearSaveTo);
            Graphics::ResizeAndSave($tmpName, $clearSaveTo,
                480, 360, array('x1'=>0, 'y1'=>0));
            $newImage = $path . $namePrefix . '_140.jpg';
            Graphics::ResizeAndSave($clearSaveTo, $newImage, 140, 80, array('x1'=>0, 'y1'=>0));
            $newImage = $path . $namePrefix . '_450.jpg';
            Graphics::ResizeAndSave($clearSaveTo, $newImage, 450, 254, array('x1'=>0, 'y1'=>0));
          }
        }
      }
    }
    self::PrintVideoFeed($videoFeed);
    //print_r($query);

  }

  public static function ClearLink($link)
  {
    return substr($link, 0, strpos($link, '?'));
  }

  /**
   * @static
   * @param int $videoId
   * @return VideoPost|null
   */
  public static function GetById($videoId)
  {
    $video = VideoPost::model();
    return $video->findByPk($videoId);
  }

  /**
   * @static
   * @param string $link
   * @return VideoPost|null
   */
  public static function GetVideoByLink($link)
  {
    $news = VideoPost::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.LinkHash LIKE :LinkHash';
    $criteria->params = array(':LinkHash' => self::GetLinkHash($link));
    return $news->find($criteria);
  }

  public function GetThumbnailsDir($onServerDisc = false)
  {
    $result = Registry::GetVariable('VideoThumbnailsDir');
    if ($onServerDisc)
    {
      $result = $_SERVER['DOCUMENT_ROOT'] . $result;
    }

    return $result;
  }

  public function GetThumbnailImage($onServerDisc = false)
  {
    $path = $this->GetThumbnailsDir($onServerDisc);
    $namePrefix = $this->VideoPostId;
    return $path . $namePrefix . '_140.jpg';
  }

  public function GetThumbnailImageBig($onServerDisc = false)
  {
    $path = $this->GetThumbnailsDir($onServerDisc);
    $namePrefix = $this->VideoPostId;
    return $path . $namePrefix . '_450.jpg';
  }

  /**
   * @static
   * @param int $page
   * @param int $perPage
   * @return VideoPost[]
   */
  public static function GetByCount($count)
  {
    $video = VideoPost::model();

    $criteria = new CDbCriteria();
    $criteria->condition = 't.Status = :Status';
    $criteria->params[':Status'] = self::StatusPublish;
    $criteria->limit = $count;
    $criteria->order = 'PostDate DESC';

    return $video->findAll($criteria);
  }

  /**
   * @param string $link
   * @return array
   */
  public static function ParseLink($link)
  {
    $parts = preg_split('/-/', trim($link), 2, PREG_SPLIT_NO_EMPTY);
    if (sizeof($parts) != 2)
    {
      return array();
    }
    return array('id' => $parts[0], 'link' => $parts[1]);
  }

  /**
   * @return string
   */
  public function GetUrl()
  {
    return $this->VideoPostId . '-' . $this->Name;
  }

  private static function GetLinkHash($link)
  {
    return md5($link);
  }

  public function SetLink($link)
  {
    $this->Link = $link;
    $this->LinkHash = self::GetLinkHash($link);
  }



  public static function PrintVideoFeed($videoFeed, $displayTitle = null)
  {
    $count = 1;
    if ($displayTitle === null) {
      $displayTitle = $videoFeed->title->text;
    }
    echo '<h2>' . $displayTitle . "</h2>\n";
    echo "<pre>\n";
    foreach ($videoFeed as $videoEntry) {
      echo 'Entry # ' . $count . "\n";
      self::PrintVideoEntry($videoEntry);
      echo "\n";
      $count++;
    }
    echo "</pre>\n";
  }

  /**
   * @static
   * @param Zend_Gdata_App_Entry $videoEntry
   * @param string $tabs
   * @return void
   */
  public static function PrintVideoEntry($videoEntry, $tabs = "")
  {
    echo 'Video test: ' . $videoEntry->getPublished() . "\n";
    // the videoEntry object contains many helper functions that access the underlying mediaGroup object
    echo $tabs . 'Video id: ' . $videoEntry->getId() . "\n";
    echo $tabs . 'Video: ' . $videoEntry->getVideoTitle() . "\n";
    echo $tabs . "\tDescription: " . $videoEntry->getVideoDescription() . "\n";
    echo $tabs . "\tCategory: " . $videoEntry->getVideoCategory() . "\n";
    echo $tabs . "\tTags: " . implode(", ", $videoEntry->getVideoTags()) . "\n";
    echo $tabs . "\tWatch page: " . $videoEntry->getVideoWatchPageUrl() . "\n";
    echo $tabs . "\tFlash Player Url: " . $videoEntry->getFlashPlayerUrl() . "\n";
    echo $tabs . "\tDuration: " . $videoEntry->getVideoDuration() . "\n";
    echo $tabs . "\tView count: " . $videoEntry->getVideoViewCount() . "\n";
    echo $tabs . "\tRating: " . $videoEntry->getVideoRatingInfo() . "\n";
    echo $tabs . "\tGeo Location: " . $videoEntry->getVideoGeoLocation() . "\n";

    // see the paragraph above this function for more information on the 'mediaGroup' object
    // here we are using the mediaGroup object directly to its 'Mobile RSTP link' child
    foreach ($videoEntry->mediaGroup->content as $content) {
      if ($content->type === "video/3gpp") {
        echo $tabs . "\tMobile RTSP link: " . $content->url . "\n";
      }
    }

    echo $tabs . "\tThumbnails:\n";
    $videoThumbnails = $videoEntry->getVideoThumbnails();

    foreach($videoThumbnails as $videoThumbnail) {
      echo $tabs . "\t\t" . $videoThumbnail['time'] . " - <img src=\"" . $videoThumbnail['url'] . '">';
      echo " height=" . $videoThumbnail['height'];
      echo " width=" . $videoThumbnail['width'];
      echo "\n";
    }
  }
}
