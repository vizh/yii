<?php
AutoLoader::Import('library.rocid.user.*');

/**
 * @property int $CoverId
 * @property int $UserId
 * @property string $Hash
 * @property string $CreationTime
 *
 * @property User $User
 */
class NewsCover extends CActiveRecord
{
  const DirFilesBase = 'base';
  const DirFilesPhoto = 'photo';
  const DirFilesCover = 'result';
  const DirFilesFonts = 'fonts';

  const Width = 500;
  const Height = 708;

  const FontSizeTop = 24;
  const FontSizeBottom = 15;
  const TextPaddingLeft = 30;
  const TextStartTop = 595;
  //const TestDeltaTop = 35;

  const TextLengthTop = 50;
  const TextLengthBottom = 40;

  const LineDelta = 6;

  public static $TableName = 'Mod_NewsCover';

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
    return 'CoverId';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, 'User', 'UserId')
    );
  }

  /**
   * @static
   * @param int $coverId
   * @return NewsCover
   */
  public static function GetById($coverId)
  {
    $cover = NewsCover::model()->with('User');
    return $cover->findByPk($coverId);
  }

  /**
   * @static
   * @param int|null $userId
   * @param int $count
   * @param array $exclude
   * @return NewsCover[]
   */
  public static function GetByUserId($userId, $count, $exclude = array())
  {
    $cover = NewsCover::model();
    $criteria = new CDbCriteria();
    if ($userId !== null)
    {
      $criteria->condition = 't.UserId = :UserId';
      $criteria->params[':UserId'] = $userId;
    }
    else
    {
      $criteria->condition = '1=1';
    }


    if (! empty($exclude))
    {
      $criteria->condition .= ' AND t.CoverId NOT IN ( ' . implode(',', $exclude) . ' )';
    }
    $criteria->order = 't.CreationTime DESC';
    $criteria->limit = $count;

    return $cover->findAll($criteria);
  }


  /**
   * @static
   * @return resource
   */
  public static function GetTopImage()
  {
    $path = self::GetBaseDir(true);
    $path .= self::DirFilesBase . '/';
    $path .= 'top.png';
    $image = imagecreatefrompng($path);
    return $image;
  }

  /**
   * @static
   * @return resource
   */
  public static function GetBottomImage()
  {
    $path = self::GetBaseDir(true);
    $path .= self::DirFilesBase . '/';
    $path .= 'bottom.png';
    $image = imagecreatefrompng($path);
    return $image;
  }

  /**
   * @static
   * @return string
   */
  public static function GetFont()
  {
    $path = self::GetBaseDir(true);
    $path .= self::DirFilesFonts . '/';
    $path .= 'helveticalight.ttf';//'HelveticaLight.ttf';
    return $path;
  }

  /**
   * @static
   * @param bool $onServerDisc
   * @return string
   */
  public static function GetBaseDir($onServerDisc = false)
  {
    $result = Registry::GetVariable('NewsCoverDir');
    if ($onServerDisc)
    {
      $result = $_SERVER['DOCUMENT_ROOT'] . $result;
    }

    return $result;
  }

  public function GetPhotoPath($onServerDisc = false)
  {
    $path = self::GetBaseDir($onServerDisc);
    $path .= self::DirFilesPhoto . '/';
    $path .= $this->CoverId . '-' . $this->Hash . '.jpg';
    return $path;
  }

  public function GetResultPath($onServerDisc = false)
  {
    $path = self::GetBaseDir($onServerDisc);
    $path .= self::DirFilesCover . '/';
    $path .= $this->CoverId . '-' . $this->Hash . '.png';
    return $path;
  }

  public static function Generate($topText, $bottomText, $fileName, $userId)
  {
    $topText = mb_strtoupper($topText, Registry::Encoding);
    $bottomText = mb_strtoupper($bottomText, Registry::Encoding);

    $cover = new NewsCover();
    $cover->UserId = $userId;
    $cover->Hash = md5(microtime() . srand((int)microtime()));
    $cover->CreationTime = date('Y-m-d H:i:s');
    $cover->save();

    $photoPath = $cover->GetPhotoPath(true);
    Graphics::SaveImageFromPost($fileName, $photoPath);
    Graphics::ResizeAndSave($photoPath, $photoPath, NewsCover::Width, 0);

    $result = imagecreatetruecolor(NewsCover::Width, NewsCover::Height);
    $topImage = NewsCover::GetTopImage();
    $bottomImage = NewsCover::GetBottomImage();
    $photo = imagecreatefromjpeg($photoPath);

    $height = min(NewsCover::Height, imagesy($photo));
    $top = 100;
    imagecopy($result, $photo,
                     0, $top,
                     0, 0,
                     NewsCover::Width, $height);
    imagecopy($result, $topImage, 0, 0, 0, 0,
              NewsCover::Width, NewsCover::Height);
    imagecopy($result, $bottomImage, 0, 0, 0, 0,
              NewsCover::Width, NewsCover::Height);

    $words = preg_split('/ /', $topText, -1, PREG_SPLIT_NO_EMPTY);
    $var1 = array('line1' => '', 'line2' => '');
    $var2 = array('line1' => '', 'line2' => '');
    $flag = false;
    $baseLength = mb_strlen($topText, Registry::Encoding);
    foreach($words as $word)
    {
      if (mb_strlen($var1['line1'], Registry::Encoding) < ($baseLength/2))
      {
        $var1['line1'] .= (! empty($var1['line1']) ? ' ' : '') . $word;
      }
      else
      {
        $var1['line2'] .= (! empty($var1['line2']) ? ' ' : '') . $word;
      }

      if (! $flag && mb_strlen($var2['line1'] . ' ' . $word, Registry::Encoding) < ($baseLength/2))
      {
        $var2['line1'] .= (! empty($var2['line1']) ? ' ' : '') . $word;
      }
      else
      {
        $flag = true;
        $var2['line2'] .= (! empty($var2['line2']) ? ' ' : '') . $word;
      }
    }

    $variant = null;
    $fontSizeTop = NewsCover::FontSizeTop;
    $maxTextWidth = NewsCover::Width - 2 * NewsCover::TextPaddingLeft;
    while ($variant == null)
    {
      $box = imagettfbbox($fontSizeTop, 0, NewsCover::GetFont(), $var1['line1']);
      if ($box[2] - $box[0] < $maxTextWidth)
      {
        $variant = 1;
        break;
      }

      $box = imagettfbbox($fontSizeTop, 0, NewsCover::GetFont(), $var2['line2']);
      if ($box[2] - $box[0] < $maxTextWidth)
      {
        $variant = 2;
        break;
      }
      $fontSizeTop -= 2;
    }
    $line1 = ($variant == 1) ? $var1['line1'] : $var2['line1'];
    $line2 = ($variant == 1) ? $var1['line2'] : $var2['line2'];

    $fontSizeBottom = NewsCover::FontSizeBottom;
    while(true)
    {
      $box = imagettfbbox($fontSizeBottom, 0, NewsCover::GetFont(), $bottomText);
      if ($box[2] - $box[0] < $maxTextWidth)
      {
        break;
      }
      $fontSizeBottom -= 1;
    }

    $box = imagettfbbox($fontSizeTop, 0, NewsCover::GetFont(), $line1);
    imagettftext($result, $fontSizeTop, 0,
                 NewsCover::TextPaddingLeft, NewsCover::TextStartTop,
                 0x000000, NewsCover::GetFont(), $line1);
    imageline($result, NewsCover::TextPaddingLeft, NewsCover::TextStartTop + NewsCover::LineDelta,
              NewsCover::TextPaddingLeft  + $box[2] - $box[0] + NewsCover::LineDelta,
              NewsCover::TextStartTop + NewsCover::LineDelta, 0x000000);

    $textStartTop = NewsCover::TextStartTop + $fontSizeTop + 2 * NewsCover::LineDelta;
    $box = imagettfbbox($fontSizeTop, 0, NewsCover::GetFont(), $line2);
    imagettftext($result, $fontSizeTop, 0,
                 NewsCover::TextPaddingLeft, $textStartTop, 0x000000, NewsCover::GetFont(), $line2);

    imageline($result, NewsCover::TextPaddingLeft, $textStartTop + NewsCover::LineDelta,
              NewsCover::TextPaddingLeft  + $box[2] - $box[0] + NewsCover::LineDelta,
              $textStartTop + NewsCover::LineDelta, 0x000000);

    $textStartTop += $fontSizeBottom + 3 * NewsCover::LineDelta;
    $box = imagettfbbox($fontSizeBottom, 0, NewsCover::GetFont(), $bottomText);
    imagettftext($result, $fontSizeBottom, 0,
                 NewsCover::TextPaddingLeft, $textStartTop, 0x000000, NewsCover::GetFont(), $bottomText);
    imageline($result, NewsCover::TextPaddingLeft, $textStartTop + NewsCover::LineDelta - 2,
              NewsCover::TextPaddingLeft  + $box[2] - $box[0] + NewsCover::LineDelta - 2,
              $textStartTop + NewsCover::LineDelta - 2, 0x000000);


    imagejpeg($result, $cover->GetResultPath(true), 90);

    return $cover;
  }
}
