<?php
namespace event\models\forms\widgets\header;

use event\components\widget\WidgetAdminPanelForm;
use event\models\Event;

/**
 * Class Header
 * @package event\models\forms\widgets\header
 */
class Header extends WidgetAdminPanelForm
{
    public $WidgetHeaderBackgroundImage;
    public $WidgetHeaderStyles;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['WidgetHeaderBackgroundImage', 'file', 'types' => 'jpg,jpeg,png', 'allowEmpty' => true],
            ['WidgetHeaderStyles', 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'WidgetHeaderBackgroundImage' => \Yii::t('app', 'Фоновое изображение'),
            'WidgetHeaderBackgroundImage_en' => \Yii::t('app', 'Фоновое изображение (Для англ. версии)'),

            'WidgetHeaderStyles' => \Yii::t('app', 'Стили')
        ];
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
        if ($this->WidgetHeaderBackgroundImage !== null) {
            $this->model->getHeaderBackgroundImage()->upload($this->WidgetHeaderBackgroundImage);
        }
        return $this->model;
    }

    /**
     * Заполняет параметры формы из POST запроса
     */
    public function fillFromPost()
    {
        parent::fillFromPost();
        $this->WidgetHeaderBackgroundImage = \CUploadedFile::getInstance($this, 'WidgetHeaderBackgroundImage');
    }
}
