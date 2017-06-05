<?php
namespace event\widgets\header;

use event\components\Widget;
use event\components\WidgetPosition;

/***
 * Class Header
 * @package event\widgets
 *
 * @property string $WidgetHeaderStyles
 */
class Header extends Widget
{
    public function getAttributeNames()
    {
        return ['WidgetHeaderStyles'];
    }

    public function getIsHasDefaultResources()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function registerDefaultResources()
    {
        $css = $this->getCss();
        if (!empty($css)) {
            \Yii::app()->getClientScript()->registerCss($this->getNameId(), $css);
        }
        parent::registerDefaultResources();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->render('header', []);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Шапка мероприятия');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return WidgetPosition::Header;
    }

    /**
     * Стили для виджета
     * @return string
     */
    protected function getCss()
    {
        $css = '';
        if (isset($this->WidgetHeaderStyles)) {
            $css .= $this->WidgetHeaderStyles.' ';
        }

        $background = $this->getEvent()->getHeaderBackgroundImage();
        if ($background->exists()) {
            $css .= $this->getBaseCssPath().' {
                background: url(\''.$background->original().'\') repeat-x center center;
            }';
        }

        return $css;
    }

    /**
     * @return string
     */
    protected function getBaseCssPath()
    {
        return '.b-event-promo.'.$this->getEvent()->IdName;
    }
}
