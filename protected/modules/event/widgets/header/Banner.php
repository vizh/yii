<?php
namespace event\widgets\header;

/**
 * Class Banner
 * @package event\widgets\header
 *
 * @property string $WidgetHeaderBannerBackgroundColor
 * @property int $WidgetHeaderBannerHeight
 */
class Banner extends Header
{
    /**
     * @return array
     */
    public function getAttributeNames()
    {
        $attributes = [
            'WidgetHeaderBannerBackgroundColor',
            'WidgetHeaderBannerHeight'
        ];
        return array_merge($attributes, parent::getAttributeNames());
    }

    /**
     * @throws \CException
     */
    public function run()
    {
        $this->render('banner');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Кастомизированная шапка мероприятия в виде баннера');
    }

    /**
     * @inheritdoc
     */
    protected function getCss()
    {
        $css = parent::getCss();
        if (isset($this->WidgetHeaderBannerBackgroundColor)) {
            $css .= $this->getBaseCssPath().' {
                background-color: #'.$this->WidgetHeaderBannerBackgroundColor.';
            }';
        }

        $css .= $this->getBaseCssPath().' .container {
            padding: 0;';

        $banner = $this->getEvent()->getHeaderBannerImage();
        if ($banner->exists()) {
            $css .= 'background: url('.$banner->resize(940).') no-repeat center center;';
        }

        if (isset($this->WidgetHeaderBannerHeight)) {
            $css .= 'height: '.$this->WidgetHeaderBannerHeight.'px;';
        }

        $css .= '}';
        return $css;
    }

}
