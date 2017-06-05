<?php
namespace partner\models\forms\program;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use event\models\Event;
use event\models\section\Attribute;
use event\models\section\Hall;
use event\models\section\LinkHall;
use event\models\section\Section as SectionModel;
use event\models\section\Type;

class Section extends CreateUpdateForm
{
    public $Title;

    public $ShortTitle;

    public $Info;

    public $Date;

    public $TimeStart;

    public $TimeEnd;

    public $Hall = [];

    public $HallNew;

    public $Attribute;

    public $AttributeNew;

    public $TypeId;

    /** @var Event */
    private $event;

    /** @var string */
    private $locale;

    /** @var SectionModel */
    protected $model;

    /**
     * @param Event $event
     * @param SectionModel $model
     * @param null $locale
     */
    public function __construct(Event $event, SectionModel $model = null, $locale = null)
    {
        $this->event = $event;
        $this->locale = $locale == null ? \Yii::app()->sourceLanguage : $locale;
        if ($model !== null) {
            $model->setLocale($this->locale);
        }
        parent::__construct($model);
    }

    public function attributeLabels()
    {
        return [
            'Title' => \Yii::t('app', 'Название секции'),
            'ShortTitle' => \Yii::t('app', 'Краткое название секции'),
            'Info' => \Yii::t('app', 'Описание'),
            'Date' => \Yii::t('app', 'Дата'),
            'Hall' => \Yii::t('app', 'Зал'),
            'AttributeNew' => \Yii::t('app', 'Новый атрибут'),
            'TimeStart' => \Yii::t('app', 'Время начала'),
            'TimeEnd' => \Yii::t('app', 'Время окончания'),
            'TypeId' => \Yii::t('app', 'Тип')
        ];
    }

    public function rules()
    {
        return [
            ['HallNew', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Title,ShortTitle,Info', 'filter', 'filter' => [$this, 'filterHtmlText']],
            ['Title, Date, TimeStart, TimeEnd, TypeId', 'required'],
            ['Date', 'date', 'format' => 'yyyy-MM-dd'],
            ['TimeStart, TimeEnd', 'date', 'format' => 'HH:mm'],
            ['Hall', 'validateHall'],
            ['Attribute', 'safe'],
            ['AttributeNew', 'filter', 'filter' => [$this, 'filterAttributeNew']],
            ['TypeId', 'in', 'range' => array_keys($this->getTypeData())]
        ];
    }

    /**
     * @param $value
     * @return string
     */
    public function filterHtmlText($value)
    {
        $purifier = new \CHtmlPurifier();
        $purifier->options = [
            'HTML.AllowedElements' => ['span', 'strong', 'a', 'br', 'u', 'h1', 'h2', 'h3', 'h4', 'h5', 'ul', 'li', 'ol', 'p', 'table', 'tr', 'td', 'tbody', 'thead', 'th', 'img'],
            'Attr.AllowedFrameTargets' => ['_blank', '_self']
        ];
        return $purifier->purify($value);
    }

    public function filterAttributeNew($value)
    {
        if (!empty($value['Name']) && !preg_match('/^\w[\w\d_]*$/i', $value['Name'])) {
            $this->addError('AttributeNew', \Yii::t('app', 'Неверное имя атрибута. Разрешается использование только латинских букв, цифр и "_".'));
        }
        return $value;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function validateHall($attribute)
    {
        if (empty($this->Hall) && empty($this->HallNew)) {
            $this->addError($attribute, \Yii::t('app', 'Должен быть указан хотя бы один зал!'));
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getDateData()
    {
        $data = [];
        $datetime = new \DateTime();
        $datetime->setTimestamp($this->event->getTimeStampStartDate());
        while ($datetime->getTimestamp() <= $this->event->getTimeStampEndDate()) {
            $data[$datetime->format('Y-m-d')] = $datetime->format('d.m.Y');
            $datetime->modify('+1 day');
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getAttributeList()
    {
        $attributes = \Yii::app()->db->createCommand()
            ->from(Attribute::model()->tableName().' Attribute')
            ->selectDistinct('Attribute.Name')
            ->join(SectionModel::model()->tableName()." as Section", '"Section"."Id" = "Attribute"."SectionId"')
            ->where('"Section"."EventId" = :EventId AND NOT "Section"."Deleted"', ['EventId' => $this->event->Id])
            ->queryColumn();

        if ($this->isUpdateMode() && !\Yii::app()->getRequest()->getIsPostRequest()) {
            foreach ($this->model->Attributes as $attribute) {
                $this->Attribute[$attribute->Name] = $attribute->Value;
            }
        }
        return $attributes;
    }

    /**
     * @return array
     */
    public function getTypeData()
    {
        return \CHtml::listData(Type::model()->findAll(), 'Id', 'Title');
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return bool
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            $formatter = \Yii::app()->getDateFormatter();
            $this->Date = $formatter->format('yyyy-MM-dd', $this->model->StartTime);
            $this->TimeStart = $formatter->format('HH:mm', $this->model->StartTime);
            $this->TimeEnd = $formatter->format('HH:mm', $this->model->EndTime);
            foreach ($this->model->LinkHalls as $linkHall) {
                $this->Hall[] = $linkHall->HallId;
            }
            return true;
        }
        return false;
    }

    /**
     * @return SectionModel|null
     */
    public function createActiveRecord()
    {
        $this->model = new SectionModel();
        $this->model->EventId = $this->event->Id;
        return $this->updateActiveRecord();
    }

    /**
     * @return SectionModel|null
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        /** @var \CDbTransaction $transaction */
        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->fillActiveRecord();
            $this->model->StartTime = $this->Date.' '.$this->TimeStart;
            $this->model->EndTime = $this->Date.' '.$this->TimeEnd;
            $this->model->save();

            foreach ($this->getAttributeList() as $name) {
                $this->model->setSectionAttribute($name, $this->Attribute[$name]);
            }

            foreach ($this->event->Halls as $hall) {
                $link = LinkHall::model()->byHallId($hall->Id)->bySectionId($this->model->Id)->find();
                if (in_array($hall->Id, $this->Hall) && $link == null) {
                    $this->model->setHall($hall);
                } elseif (!in_array($hall->Id, $this->Hall) && $link !== null) {
                    $link->delete();
                }
            }

            if (!empty($this->HallNew)) {
                $hall = new Hall();
                $hall->Title = $this->HallNew;
                $hall->EventId = $this->event->Id;
                $hall->save();
                $this->model->setHall($hall);
            }

            if (!empty($this->AttributeNew['Name'])) {
                $this->model->setSectionAttribute($this->AttributeNew['Name'], $this->AttributeNew['Value']);
            }

            $transaction->commit();
            return $this->model;
        } catch (\CDbException $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }
        return null;
    }

}
