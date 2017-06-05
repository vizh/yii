<?php
namespace event\models\forms\widgets\header;

use event\models\Event;

/**
 * @inheritdoc
 */
class Banner extends Header
{
    public $WidgetHeaderBannerBackgroundColor;

    public $WidgetHeaderBannerHeight;

    public $WidgetHeaderBannerImage;

    public $WidgetHeaderBannerImage_en;

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            ['WidgetHeaderBannerImage,WidgetHeaderBannerImage_en', 'file', 'types' => 'jpg,jpeg,png', 'allowEmpty' => true],
            ['WidgetHeaderBannerBackgroundColor', 'safe'],
            ['WidgetHeaderBannerHeight', 'numerical']
        ];
        return array_merge($rules, parent::rules());
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge([
            'WidgetHeaderBannerImage' => \Yii::t('app', 'Баннер'),
            'WidgetHeaderBannerImage_en' => \Yii::t('app', 'Баннер англ. версия'),
            'WidgetHeaderBannerBackgroundColor' => \Yii::t('app', 'Цвет фона'),
            'WidgetHeaderBannerHeight' => \Yii::t('app', 'Высота шапки'),
        ], parent::attributeLabels());
    }

    /**
     * Обновляет запись в базе
     * @return Event|null
     * @throws Exception
     */
    public function updateActiveRecord()
    {
        if (parent::updateActiveRecord() === null) {
            return null;
        }

        if ($this->WidgetHeaderBannerImage !== null) {
            $this->model->getHeaderBannerImage()->upload($this->WidgetHeaderBannerImage);
        }

        if ($this->WidgetHeaderBannerImage_en !== null) {
            $this->model->setLocale('en');
            $this->model->getHeaderBannerImage(false)->upload($this->WidgetHeaderBannerImage_en);
            $this->model->resetLocale();
        }

        return $this->model;
    }

    /**
     * Заполняет параметры формы из POST запроса
     */
    public function fillFromPost()
    {
        parent::fillFromPost();
        $this->WidgetHeaderBannerImage = \CUploadedFile::getInstance($this, 'WidgetHeaderBannerImage');
        $this->WidgetHeaderBannerImage_en = \CUploadedFile::getInstance($this, 'WidgetHeaderBannerImage_en');
    }
}
