<?php

/**
 * @property int $NewsPromoId
 * @property string $TitleTop
 * @property string $Title
 * @property string $Description
 * @property string $Link
 * @property int $Position
 * @property string $Status
 * @property string $PostDate
 * @property int $OnTop
 *
 */
class NewsPromo extends CActiveRecord
{
  public static $TableName = 'Mod_NewsPromo';

  const StatusAny = 'any';
  const StatusPublish = 'publish';
  const StatusHide = 'hide';
  const StatusDraft = 'draft';

  public static $Statuses = array(self::StatusPublish, self::StatusDraft, self::StatusHide);

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
    return 'NewsPromoId';
  }

  public function relations()
  {
    return array(
    );
  }

  /**
   * @static
   * @param int $newsId
   * @return NewsPromo|null
   */
  public static function GetById($promoId)
  {
    $promo = NewsPromo::model();
    return $promo->findByPk($promoId);
  }

  /**
   * @static
   * @param int $page
   * @param int $perPage
   * @return NewsPromo[]
   */
  public static function GetByPage($page, $perPage, $onTop = 0)
  {
    $promo = NewsPromo::model();

    $criteria = new CDbCriteria();
    //$criteria->condition = 't.OnTop = :OnTop';
    //$criteria->params = array(':OnTop' => $onTop);
    $criteria->offset = $perPage * ($page - 1);
    $criteria->limit = $perPage;
    $criteria->order = 'PostDate DESC';

    return $promo->findAll($criteria);
  }

  /**
   * @static
   * @param int $count
   * @param int $onTop
   * @return NewsPromo[]
   */
  public static function GetTape($count, $onTop)
  {
    $promo = NewsPromo::model();

    $criteria = new CDbCriteria();
    $criteria->condition = 't.OnTop = :OnTop AND t.Status = :Status';
    $criteria->params = array(':OnTop' => $onTop, ':Status' => self::StatusPublish);
    $criteria->limit = $count;
    $criteria->order = 'Position, PostDate DESC';

    return $promo->findAll($criteria);
  }



  public function GetImageDir($onServerDisc = false)
  {
    $result = Registry::GetVariable('NewsPromoDir');
    if ($onServerDisc)
    {
      $result = $_SERVER['DOCUMENT_ROOT'] . $result;
    }

    return $result;
  }

  public function GetImage($onServerDisc = false)
  {
    $path = $this->GetImageDir($onServerDisc);
    $namePrefix = $this->NewsPromoId;
    return $path . $namePrefix . '_200.jpg';
  }

  public function GetImageBig($onServerDisc = false)
  {
    $path = $this->GetImageDir($onServerDisc);
    $namePrefix = $this->NewsPromoId;
    return $path . $namePrefix . '_400.jpg';
  }
}
