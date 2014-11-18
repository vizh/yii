<?php
namespace event\widgets;

class Header extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return ['HeaderBannerStyles'];
    }

    public function getIsHasDefaultResources()
    {
        return true;
    }

    public function run()
    {
        if (isset($this->HeaderBannerStyles))
        {
            \Yii::app()->getClientScript()->registerCss($this->getNameId(), $this->HeaderBannerStyles);
        }
        $this->render('header', array());
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
        return \event\components\WidgetPosition::Header;
    }
}
