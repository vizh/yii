<?php
AutoLoader::Import('library.texts.*');
AutoLoader::Import('library.rocid.company.*');

/**
 * @property int $NewsRssId
 * @property string $Link
 * @property string $LastUpdate
 * @property string $NextUpdate
 * @property string $MetaData
 * @property int $CompanyId
 *
 * @property Company $Company
 */
class NewsRss extends CActiveRecord implements ISettingable
{
  /**
   * Возвращает массив вида:
   * array('name1'=>array('DefaultValue', 'Description'),
   *       'name2'=>array('DefaultValue', 'Description'), ...)
   */

  public function GetSettingList()
  {
    return array('CompanyCategoryId' => array(11, 'Идентификатор категории "Новости компаний"'));
  }

  public static $TableName = 'Mod_NewsRss';

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
    return 'NewsRssId';
  }

  public function relations()
  {
    return array(
      'Company' => array(self::BELONGS_TO, 'Company', 'CompanyId'),
    );
  }

  public static function GetById($id)
  {
    return NewsRss::model()->findByPk($id);
  }

  /**
   * @static
   * @param int $companyId
   * @return NewsRss|null
   */
  public static function GetRssByCompany($companyId)
  {
    $rss = NewsRss::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.CompanyId = :CompanyId';
    $criteria->params = array(':CompanyId' => $companyId);
    return $rss->find($criteria);
  }

  /**
   * @static
   * @return NewsRss
   */
  public static function GetFirstInQueue()
  {
    $rss = NewsRss::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.NextUpdate < :CurrentTime';
    $criteria->params = array(':CurrentTime' => date('Y-m-d H:i:s'));
    $criteria->order = 't.NextUpdate';
    return $rss->find($criteria);
  }

  public static function UpdateFirstInQueue()
  {
    $rss = self::GetFirstInQueue();

    if (! empty($rss))
    {
      $rss->UpdateRss();
    }
  }

  /**
   * @static
   * @return NewsRss[]
   */
  public static function GetAll()
  {
    return NewsRss::model()->with('Company')->together()->findAll();
  }

  public function SetupNextUpdate()
  {
    $this->NextUpdate = date('Y-m-d H:i:s', time() + 12 * 60 * 60);
  }

  public function UpdateRss()
  {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->Link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    if (!empty($result))
    {
      $rssXml = simplexml_load_string($result);
      foreach ($rssXml->channel->item as $item)
      {
        $link = $item->link;
        $news = NewsPost::GetNewsByLink($link);
        if ($news == null)
        {
          $news = new NewsPost();
          $news->NewsRssId = $this->NewsRssId;
          if (isset($item->pubDate))
          {
            $news->PostDate = date('Y-m-d H:i:s', strtotime($item->pubDate));
          }
          $news->Title = $item->title;
          $news->Name = Texts::CyrToLatTitle($item->title);
          $news->SetLinkFromRss($link);
          $news->Content = $item->description;
          $news->Status = NewsPost::StatusModerate;
          $news->NewsCategoryId = intval(SettingManager::GetSetting('CompanyCategoryId'));
          $news->save();

          $news->AddCompany($this->CompanyId);
        }
      }
    }
    $this->SetupNextUpdate();
    $this->LastUpdate = date('Y-m-d H:i:s');
    $this->save();
  }
}
