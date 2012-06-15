<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('library.texts.*');

/**
 * @property int $NewsPostId
 * @property int $NewsCategoryId
 * @property int $UserId
 * @property int $EventId
 * @property int $NewsRssId
 * @property string $PostDate
 * @property string $Title
 * @property string $Name
 * @property string $LinkFromRss
 * @property string $LinkFromRssHash
 * @property string $Quote
 * @property string $Content
 * @property string $MaterialType
 * @property string $Copyright
 * @property string $Status
 * @property int $InMainTape
 *
 * @property Event $Event
 * @property User $Author
 * @property Company[] $Companies
 * @property NewsCategories[] $Categories
 * @property NewsCategories $MainCategory
 */
class NewsPost extends CActiveRecord //todo: implements ITagable
{
  public static $TableName = 'Mod_NewsPost';

  const StatusPublish = 'publish';
  const StatusModerate = 'moderate';
  const StatusDraft = 'draft';
  const StatusDeleted = 'deleted';

  const ExpertsCategoryId = 17;

  public static $Statuses = array(self::StatusPublish, self::StatusDraft, self::StatusModerate, self::StatusDeleted);

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
    return 'NewsPostId';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
      'Author' => array(self::BELONGS_TO, 'User', 'UserId'),
      'Companies' => array(self::MANY_MANY, 'Company', 'Mod_NewsLinkCompany(NewsPostId, CompanyId)'),
      'Categories' => array(self::MANY_MANY, 'NewsCategories', 'Mod_NewsLinkCategory(NewsPostId, CategoryId)'),
      'MainCategory' => array(self::BELONGS_TO, 'NewsCategories', 'NewsCategoryId')
    );
  }

  protected function beforeSave()
  {
    $this->UpdateTime = date('Y-m-d H:i:s');

    return parent::beforeSave();
  }

  /**
   * @static
   * @param int $newsId
   * @return NewsPost|null
   */
  public static function GetById($newsId)
  {
    $news = NewsPost::model();
    return $news->findByPk($newsId);
  }


  public static $GetByFromRssCount = 0;
  /**
   * @static
   * @param int $count
   * @param int $page
   * @param bool $fromRss
   * @return NewsPost[]
   */
  public static function GetByFromRss($count, $page = 1, $fromRss = false)
  {
    $criteria = new CDbCriteria();
    if ($fromRss)
    {
      $criteria->condition = 'LinkFromRss IS NOT NULL';
    }
    else
    {
      $criteria->condition = 'LinkFromRss IS NULL';
    }
    self::$GetByFromRssCount = NewsPost::model()->count($criteria);

    $criteria->offset = $count * ($page - 1);
    $criteria->limit = $count;
    $criteria->order = 't.PostDate DESC';

    return NewsPost::model()->with('Companies')->findAll($criteria);
  }

  /**
   * @static
   * @param  $count
   * @param int $page
   * @param int|null $companyId
   * @param array $exclude
   * @param string|null $status
   * @param string|null $notStatus
   * @return NewsPost[]
   */
  public static function GetLastByCompany($count, $page = 1, $companyId = null,
    $exclude = array(), $status = NewsPost::StatusPublish, $notStatus = null)
  {
    $news = NewsPost::model()->with(array('Companies' => array('together' => true, 'select' => false)));
    $criteria = new CDbCriteria();

    if ($companyId === null)
    {
      $criteria->condition = 'Companies.CompanyId IS NULL';
    }
    elseif ($companyId != 0)
    {
      $criteria->condition = 'Companies.CompanyId = :CompanyId';
      $criteria->params[':CompanyId'] = $companyId;
    }
    else
    {
      $criteria->condition = 'Companies.CompanyId IS NOT NULL';
      $criteria->group = 't.NewsPostId';
    }

    if (! empty($exclude))
    {
      $criteria->condition .= ' AND t.NewsPostId NOT IN ( ' . implode(',', $exclude) . ' )';
    }
    if (! empty($status))
    {
      $criteria->condition .= ' AND t.Status = :Status';
      $criteria->params[':Status'] = $status;
    }
    if (! empty($notStatus))
    {
      $criteria->condition .= ' AND t.Status != :NotStatus';
      $criteria->params[':NotStatus'] = $notStatus;
    }

    $criteria->offset = $count * ($page - 1);
    $criteria->limit = $count;
    $criteria->order = 't.PostDate DESC';

    return $news->findAll($criteria);
  }



  /**
   * @static
   * @param int $perPage
   * @param int $page
   * @return NewsPost[]
   */
  public static function GetNewsByPage($perPage, $page = 1)
  {
    $news = NewsPost::model()->with(array('Company', 'Event'))->together();

    $criteria = new CDbCriteria();
    $criteria->offset = $perPage * ($page - 1);
    $criteria->limit = $perPage;
    $criteria->order = 'PostDate DESC';

    return $news->findAll($criteria);
  }

  /**
   * @static
   * @param string $link
   * @return NewsPost|null
   */
  public static function GetNewsByLink($link)
  {
    $news = NewsPost::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.LinkFromRssHash LIKE :LinkHash';
    $criteria->params = array(':LinkHash' => self::GetLinkHash($link));
    return $news->find($criteria);
  }

  /**
   * @static
   * @param int $count
   * @return NewsPost[]
   */
  public static function GetLastTop($count)
  {
    $news = NewsPost::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.InMainTape != 0';

    $criteria->condition .= ' AND t.Status = :Status';
    $criteria->params[':Status'] = self::StatusPublish;

    $criteria->order = 't.PostDate DESC';
    $criteria->limit = $count;
    return $news->findAll($criteria);
  }

  public static $GetByCategoryCountLast = 0;
  /**
   * @static
   * @param int|null $categoryId
   * @param int $countPerPage
   * @param int $page
   * @param bool $calcCount
   * @param array $exclude
   * @param string|null $status
   * @param string|null $notStatus
   * @return NewsPost[]
   */
  public static function GetByCategory($categoryId, $countPerPage, $page = 1, $calcCount = false, $exclude = array(),
    $status = NewsPost::StatusPublish, $notStatus = null)
  {
    $news = NewsPost::model()->with('Author');
    $criteria = new CDbCriteria();
    if (! empty($categoryId))
    {
      $criteria->condition = 't.NewsCategoryId = :CategoryId';
      $criteria->params = array(':CategoryId' => $categoryId);
    }
    else
    {
      $criteria->condition = '1=1';
    }

    if (! empty($exclude))
    {
      $criteria->condition .= ' AND t.NewsPostId NOT IN ( ' . implode(',', $exclude) . ' )';
    }

    if (! empty($status))
    {
      $criteria->condition .= ' AND t.Status = :Status';
      $criteria->params[':Status'] = $status;
    }
    if (! empty($notStatus))
    {
      $criteria->condition .= ' AND t.Status != :NotStatus';
      $criteria->params[':NotStatus'] = $notStatus;
    }

    if ($calcCount)
    {
      self::$GetByCategoryCountLast = $news->count($criteria);
    }

    $criteria->order = 't.PostDate DESC';
    $criteria->offset = ($page - 1) * $countPerPage;
    $criteria->limit = $countPerPage;

    return $news->findAll($criteria);
  }

  public static $GetBySearchCount = 0;
  /**
   * @static
   * @param string $searchTerm
   * @param int $count
   * @param int $page
   * @param bool $calcCount
   * @param bool $onlyCount
   * @return NewsPost[]
   */
  public static function GetBySearch($searchTerm, $count = 20, $page = 1,
    $calcCount = false, $onlyCount = false)
  {
    $news = NewsPost::model();

    $criteria = new CDbCriteria();
    $criteria->condition = 'MATCH (Title, Content) AGAINST (:Search) AND t.Status = :Status';
    $criteria->params = array(':Search' => $searchTerm, ':Status' => NewsPost::StatusPublish);

    if ($calcCount || $onlyCount)
    {
      self::$GetBySearchCount = $news->count($criteria);
      if (self::$GetBySearchCount == 0 || $onlyCount)
      {
        return array();
      }
    }
    $criteria->offset = ($page - 1) * $count;
    $criteria->limit = $count;
    return $news->findAll($criteria);
  }

  /**
   * @static
   * @param string $title
   * @param string $description
   * @param string $link
   * @param NewsPost[] $newsList
   * @return void
   */
  public static function GenerateFeed($title, $description, $link, $newsList)
  {
    Yii::import('ext.feed.*');

    $feed = new EFeed();

    $feed->setTitle($title);
    $feed->setDescription($description);
    $feed->setLink($link);
    $feed->addChannelTag('language', 'ru-RU');
    $time = isset($newsList[0]) ? strtotime($newsList[0]->PostDate) : time();
    $feed->addChannelTag('pubDate', date(DATE_RSS, $time));

    foreach ($newsList as $news)
    {
      $item = $feed->createNewItem();
      $item->setTitle($news->Title);
      $item->setDescription($news->GetDescription());
      $item->setDate(strtotime($news->PostDate));
      $item->setLink(RouteRegistry::GetUrl('news', '', 'show', array('newslink' => $news->GetLink())));
      $feed->addItem($item);
    }

    $feed->generateFeed();
  }

  /**
   * @param Company|int $company
   * @return void
   */
  public function AddCompany($company)
  {
    if (is_object($company))
    {
      $company = $company->CompanyId;
    }
    $db = Registry::GetDb();
    $sql = 'INSERT INTO Mod_NewsLinkCompany (`NewsPostId`, `CompanyId`)
      VALUES (:NewsPostId, :CompanyId)';
    $cmd = $db->createCommand($sql);
    $cmd->bindValue(':NewsPostId', $this->NewsPostId);
    $cmd->bindValue(':CompanyId', $company);
    $cmd->execute();
  }

  /**
   * @param Company|int $company
   * @return void
   */
  public function RemoveCompany($company)
  {
    if (is_object($company))
    {
      $company = $company->CompanyId;
    }
    $db = Registry::GetDb();
    $sql = 'DELETE FROM Mod_NewsLinkCompany WHERE `NewsPostId` = :NewsPostId AND `CompanyId` = :CompanyId';
    $cmd = $db->createCommand($sql);
    $cmd->bindValue(':NewsPostId', $this->NewsPostId);
    $cmd->bindValue(':CompanyId', $company);
    $cmd->execute();
  }

  /**
   * @param array $catIds
   * @return void
   */
  public function ParseCategories($catIds)
  {
    $allCategories = NewsCategories::GetAll();
    $newsCategories = $this->Categories;
    $temp = array();
    foreach ($allCategories as $cat)
    {
      $temp[$cat->NewsCategoryId] = $cat;
    }
    $allCategories = $temp;

    $temp = array();
    foreach ($newsCategories as $cat)
    {
      $temp[$cat->NewsCategoryId] = $cat;
    }
    $newsCategories = $temp;

    $temp = array();
    foreach ($catIds as $id)
    {
      $temp[$id] = $id;
    }
    $catIds = $temp;

    foreach ($catIds as $id)
    {
      if (isset($allCategories[$id]))
      {
        if (! isset($newsCategories[$id]))
        {
          $this->AddCategory($id);
        }
        else
        {
          unset($newsCategories[$id]);
        }
      }
    }

    foreach ($newsCategories as $cat)
    {
      $this->RemoveCategory($cat->NewsCategoryId);
    }
  }

  /**
   * @param NewsCategories|int $category
   * @return void
   */
  public function AddCategory($category)
  {
    if (is_object($category))
    {
      $category = $category->NewsCategoryId;
    }
    $db = Registry::GetDb();
    $sql = 'INSERT INTO Mod_NewsLinkCategory (`NewsPostId`, `CategoryId`)
      VALUES (:NewsPostId, :CategoryId)';
    $cmd = $db->createCommand($sql);
    $cmd->bindValue(':NewsPostId', $this->NewsPostId);
    $cmd->bindValue(':CategoryId', $category);
    $cmd->execute();
  }

  public function RemoveCategory($category)
  {
    if (is_object($category))
    {
      $category = $category->NewsCategoryId;
    }
    $db = Registry::GetDb();
    $sql = 'DELETE FROM Mod_NewsLinkCategory WHERE `NewsPostId` = :NewsPostId AND `CategoryId` = :CategoryId';
    $cmd = $db->createCommand($sql);
    $cmd->bindValue(':NewsPostId', $this->NewsPostId);
    $cmd->bindValue(':CategoryId', $category);
    $cmd->execute();
  }


  public function GetMainTapeDir($onServerDisc = false)
  {
    $result = Registry::GetVariable('NewsTapeDir');
    if ($onServerDisc)
    {
      $result = $_SERVER['DOCUMENT_ROOT'] . $result;
    }
    
    return $result;
  }

  public function GetMainTapeImage($onServerDisc = false)
  {
    $path = $this->GetMainTapeDir($onServerDisc);
    $namePrefix = $this->NewsPostId;
    return $path . $namePrefix . '_200.jpg';
  }

  public function GetMainTapeImageBig($onServerDisc = false)
  {
    $path = $this->GetMainTapeDir($onServerDisc);
    $namePrefix = $this->NewsPostId;
    return $path . $namePrefix . '_440.jpg';
  }

  /**
   * @return string
   */
  public function GetLink()
  {
    return $this->NewsPostId . '-' . $this->Name;
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
    return array('id' => $parts[0], 'name' => $parts[1]);
  }

  private static function GetLinkHash($link)
  {
    return md5($link);
  }

  public function SetLinkFromRss($link)
  {
    $this->LinkFromRss = $link;
    $this->LinkFromRssHash = self::GetLinkHash($link);
  }


/**
* ITagable Members
*/

  public function GetContentId()
  {
    return $this->NewsPostId;
  }

  public function GetContentType()
  {
    return 'NewsPost';
  }

  public function GetDescription()
  {
    $description = $this->Quote;
    if (empty($description))
    {
      $description = $this->Content;
      $description = strip_tags($description);
      $description = Texts::CropLongText($description, 400);
    }
    return $description;
  }
}
