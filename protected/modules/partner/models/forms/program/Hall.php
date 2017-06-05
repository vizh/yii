<?php
namespace partner\models\forms\program;

use application\components\form\CreateUpdateForm;
use event\models\Event;
use event\models\section\Hall as HallModel;

class Hall extends CreateUpdateForm
{
    public $Id;

    public $Title;

    public $Order;

    public $Delete;

    /** @var Event */
    private $event;

    /** @var string */
    private $locale;

    /** @var HallModel */
    protected $model;

    public function __construct(Event $event, HallModel $model, $locale)
    {
        $this->event = $event;
        $this->locale = $locale == null ? \Yii::app()->sourceLanguage : $locale;
        if ($model !== null) {
            $model->setLocale($this->locale);
        }
        parent::__construct($model);
    }

    public function rules()
    {
        return [
            ['Title, Order', 'required'],
            ['Order', 'numerical'],
            ['Delete', 'boolean', 'allowEmpty' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'Title' => \Yii::t('app', 'Название зала'),
            'Order' => \Yii::t('app', 'Сортировка')
        ];
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        $request = \Yii::app()->getRequest();
        $attributes = $request->getParam(get_class($this));

        if (is_array($attributes)) {
            foreach ($attributes as $name => $value) {
                if (isset($value[$this->model->Id])) {
                    $attributes[$name] = $value[$this->model->Id];
                }
            }
        }
        $this->setAttributes($attributes);
    }

    /**
     * @return HallModel|null
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        if ($this->Delete == 1) {
            $this->model->delete();
        } else {
            $this->fillActiveRecord();
        }
        $this->model->save();
        return $this->model;
    }

} 