<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 26.08.2015
 * Time: 13:13
 */

namespace event\models\forms\admin;

use application\components\form\CreateUpdateForm;
use event\models\Event;

/**
 * Class Promo
 * @package event\models\forms\admin
 *
 * @property Event $model
 * @method Event getActiveRecord()
 */
class Promo extends CreateUpdateForm
{
    public $BackgroundImage;

    public $BackgroundNoRepeat = false;

    public $BackgroundColor;

    public $TitleColor;

    public $TextColor;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['BackgroundImage', 'file', 'types' => ['jpeg', 'jpg', 'png', 'gif'], 'allowEmpty' => true],
            ['BackgroundNoRepeat', 'boolean'],
            ['BackgroundColor,TitleColor,TextColor', 'length', 'max' => 6, 'min' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BackgroundImage' => \Yii::t('app', 'Фоновое изображение'),
            'BackgroundNoRepeat' => \Yii::t('app', 'Не повторять фоновое изображение'),
            'BackgroundColor' => \Yii::t('app', 'Цвет фона'),
            'TitleColor' => \Yii::t('app', 'Цвет заголовков'),
            'TextColor' => \Yii::t('app', 'Цвет текста'),
        ];
    }

    /**
     * Обновляет запись в базе
     * @return Event|null
     * @throws Exception
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }
        if (!empty($this->BackgroundImage)) {
            $this->model->getPromoBackgroundImage()->upload($this->BackgroundImage);
        }
        $this->model->PromoBlockStyles = $this->buildStyleString();
        return $this->model;
    }

    /**
     * @return string
     */
    private function buildStyleString()
    {
        $path = '.event_widget_Promo.'.$this->model->IdName;
        $styles = '';
        if ($this->model->getPromoBackgroundImage()->exists() || !empty($this->BackgroundColor)) {
            $styles .= $path.'{background:';
            if ($this->model->getPromoBackgroundImage()->exists()) {
                $styles .= 'url(\''.$this->model->getPromoBackgroundImage()->original().'\') center center '.($this->BackgroundNoRepeat ? 'no-' : '').'repeat ';
            }
            if (!empty($this->BackgroundColor)) {
                $styles .= '#'.$this->BackgroundColor;
            }
            $styles .= ' !important;}';
        }

        if (!empty($this->TextColor)) {
            $styles .= $path.', '.$path.' p,'.$path.' small'.' {color: #'.$this->TextColor.' !important;}';
        }

        if (!empty($this->TitleColor)) {
            $styles .= $path.' h1,'.$path.' h2,'.$path.' h3,'.$path.' h4,'.$path.' h1 a,'.$path.' h2 a,'.$path.' h3 a,'.$path.' h4 a {color: #'.$this->TitleColor.' !important;}';
        };
        return $styles;
    }

    /**
     * Заполняет параметры формы из POST запроса
     */
    public function fillFromPost()
    {
        $this->BackgroundImage = \CUploadedFile::getInstance($this, 'BackgroundImage');
        parent::fillFromPost();
    }

}