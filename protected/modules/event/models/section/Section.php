<?php
namespace event\models\section;

use application\models\translation\ActiveRecord;
use event\models\Event;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property string $ShortTitle
 * @property string $Info
 * @property string $StartTime
 * @property string $EndTime
 * @property string $UpdateTime
 * @property int $TypeId
 * @property string $Code
 * @property bool $Deleted
 * @property bool $DeletionTIme
 *
 *
 * @property Event $Event
 * @property Attribute[] $Attributes
 * @property LinkUser[] $LinkUsers
 * @property LinkHall[] $LinkHalls
 * @property LinkTheme $LinkTheme
 * @property Type $Type
 *
 * Описание вспомогательных методов
 * @method Section   with($condition = '')
 * @method Section   find($condition = '', $params = [])
 * @method Section   findByPk($pk, $condition = '', $params = [])
 * @method Section   findByAttributes($attributes, $condition = '', $params = [])
 * @method Section[] findAll($condition = '', $params = [])
 * @method Section[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Section byId(int $id, bool $useAnd = true)
 * @method Section byEventId(int $id, bool $useAnd = true)
 * @method Section byTypeId(int $id, bool $useAnd = true)
 * @method Section byCode(string $code, bool $useAnd = true)
 * @method Section byDeleted(bool $deleted, bool $useAnd = true)
 */
class Section extends ActiveRecord
{
    protected $useSoftDelete = true;

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSection';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Attributes' => [self::HAS_MANY, '\event\models\section\Attribute', 'SectionId'],
            'LinkUsers' => [self::HAS_MANY, '\event\models\section\LinkUser', 'SectionId', 'on' => 'NOT "LinkUsers"."Deleted"', 'order' => '"LinkUsers"."Order" ASC'],
            'LinkHalls' => [self::HAS_MANY, '\event\models\section\LinkHall', 'SectionId', 'with' => ['Hall'], 'order' => '"Hall"."Order" ASC'],
            'LinkTheme' => [self::HAS_ONE, '\event\models\section\LinkTheme', 'SectionId'],
            'Type' => [self::BELONGS_TO, '\event\models\section\Type', 'TypeId'],
            'Favorites' => [self::HAS_MANY, '\event\models\section\Favorite', 'SectionId']
        ];
    }

    /**
     * @param string $date
     * @param boolean $useAnd
     * @return $this
     */
    public function byDate($date, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."StartTime" >= :DateStart AND "t"."EndTime" <= :DateEnd';
        $criteria->params['DateStart'] = $date.' 00:00:00';
        $criteria->params['DateEnd'] = $date.' 23:59:59';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param string $updateTime
     * @param bool $useAnd
     * @return $this
     */
    public function byUpdateTime($updateTime, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UpdateTime" > :UpdateTime';
        $criteria->params = ['UpdateTime' => $updateTime];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     *
     * @param \event\models\section\Hall $hall
     * @return \event\models\section\Section
     */
    public function setHall($hall)
    {
        $linkHall = new \event\models\section\LinkHall();
        $linkHall->HallId = $hall->Id;
        $linkHall->SectionId = $this->Id;
        $linkHall->save();
    }

    /**
     *
     * @param string $name
     * @param string $value
     */
    public function setSectionAttribute($name, $value)
    {
        $attribute = null;
        foreach ($this->Attributes as $attr) {
            if ($attr->Name == $name) {
                $attribute = $attr;
            }
        }
        if ($attribute == null) {
            $attribute = new \event\models\section\Attribute();
            $attribute->Name = $name;
            $attribute->SectionId = $this->Id;
        }
        $attribute->Value = $value;
        $attribute->save();
    }

    private $url;

    public function getUrl()
    {
        if ($this->url === null && isset($this->Event->UrlSectionMask)) {
            $this->url = str_replace(':SECTION_ID', $this->Id, $this->Event->UrlSectionMask);
        }

        return $this->url;
    }

    public function addToFavorite(\user\models\User $user)
    {
        if (!Favorite::model()->byUserId($user->Id)->bySectionId($this->Id)->byDeleted(false)->exists()) {
            $favorite = new Favorite();
            $favorite->SectionId = $this->Id;
            $favorite->UserId = $user->Id;
            $favorite->save();
        }
    }

    /**
     * @return \string[]
     */
    public function getTranslationFields()
    {
        return ['Title', 'Info'];
    }

    protected function beforeSave()
    {
        $this->UpdateTime = date('Y-m-d H:i:s');

        return parent::beforeSave();
    }
}