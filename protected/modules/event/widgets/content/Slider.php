<?php
namespace event\widgets\content;

use event\components\Widget;
use event\components\WidgetPosition;

/**
 * Class Slider
 * @package event\widgets\content
 *
 * @property string $WidgetContentSliderSlides
 * @property string $WidgetContentSliderBeforetext
 */
class Slider extends Widget
{
    /**
     * @inheritdoc
     */
    public function getAttributeNames()
    {
        return [
            'WidgetContentSliderBeforetext',
            'WidgetContentSliderSlides'
        ];
    }

    /**
     * @inheritdoc
     */
    public function getPosition()
    {
        return WidgetPosition::Content;
    }

    /**
     * Название виджета
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Слайдер');
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $slides = unserialize($this->WidgetContentSliderSlides);
        $this->render('slider', ['slides' => $slides]);
    }

    /**
     * @inheritdoc
     */
    public function getIsHasDefaultResources()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function registerDefaultResources()
    {
        \Yii::app()->getClientScript()->registerPackage('jquery.fotorama');
        parent::registerDefaultResources();
    }

}