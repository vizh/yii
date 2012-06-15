<?php

/**
 * @property int $NewsCategoryId
 * @property string $Title
 * @property string $Name
 * @property string $PartnerUrl
 * @property string $PartnerTitle
 * @property int $Special
 * @property int $Priority
 * @property int $Visible
 *
 * @property NewsPost[] $News
 * @property int $NewsCount
 */
class NewsCategories extends CActiveRecord
{
  public static $TableName = 'Mod_NewsCategory';

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
      'News' => array(self::MANY_MANY, 'NewsPost', 'Mod_NewsLinkCategory(CategoryId, NewsPostId)',),
      'NewsCount' => array(self::STAT, 'NewsPost', 'Mod_NewsLinkCategory(CategoryId, NewsPostId)',),
    );
  }

  /**
   * @param int $id
   * @return NewsCategories
   */
  public static function GetById($id)
  {
    $category = NewsCategories::model();
    return $category->findByPk($id);
  }

  /**
   * @param string $name
   * @return NewsCategories
   */
  public static function GetByName($name)
  {
    $category = NewsCategories::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.Name LIKE :Name';
    $criteria->params = array(':Name' => $name);
    return $category->find($criteria);
  }

  /**
   * @return NewsCategories[]
   */
  public static function GetAll($onlyVisible = false)
  {
    $criteria = new CDbCriteria();
    if ($onlyVisible)
    {
      $criteria->condition = 't.Visible = :Visible';
      $criteria->params = array(':Visible' => 1);
    }
    $criteria->order = 't.Priority';
    return NewsCategories::model()->findAll($criteria);
  }

  /**
   * @static
   * @return NewsCategories[]
   */
  public static function GetNotEmpty()
  {
    $categories = NewsCategories::model()->with(
      array('News' => array('select'=>'1 as fake',
                            'condition' => 'News.Status = :Status',
                            'params' => array(':Status' => NewsPost::StatusPublish))))->together();
    $criteria = new CDbCriteria();
    $criteria->condition = 'News.NewsPostId IS NOT NULL AND t.Visible = :Visible';
    $criteria->params = array(':Visible' => 1);

    $criteria->order = 't.Priority';

    return $categories->findAll($criteria);
  }



  public static $GetNewsCountLast = 0;
  /**
   * @param int $count
   * @param int $page
   * @return NewsPost[]
   */
  public function GetNews($count, $page)
  {
    $criteria = array();
    $criteria['order'] = 'PostDate DESC';
    $criteria['condition'] = 'Status = :Status';
    $criteria['params'] = array(':Status' => NewsPost::StatusPublish);

    self::$GetNewsCountLast = $this->NewsCount($criteria);

    $criteria['limit'] = $count;
    $criteria['offset'] = $count * ($page - 1);

    return $this->News($criteria);
  }


  public function GetPartnerLogoDir($onServerDisc = false)
  {
    $result = Registry::GetVariable('NewsPartnerDir');
    if ($onServerDisc)
    {
      $result = $_SERVER['DOCUMENT_ROOT'] . $result;
    }

    return $result;
  }

  public function GetPartnerLogo($onServerDisc = false)
  {
    $path = $this->GetPartnerLogoDir($onServerDisc);
    $namePrefix = 'category_' . $this->NewsCategoryId;
    return $path . $namePrefix . '.png';
  }

  /**
   * @return null|string
   */
  public function GetSpecialIcon()
  {
    $path = '/files/news/categories/' . $this->Name . '.png';
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $path))
    {
      return $path;
    }
    return null;
  }


  /**
   * @return null|View
   */
  public function GetSpecialBanner()
  {
    $view = new View();
    $view->SetTemplate($this->Name, 'news', 'banner', '', 'public');
    if (! $view->IsExistTemplate())
    {
      return null;
    }

    return $view;
  }
}
