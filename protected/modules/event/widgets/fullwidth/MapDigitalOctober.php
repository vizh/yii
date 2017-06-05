<?php
namespace event\widgets\fullwidth;

class MapDigitalOctober extends \event\components\Widget
{
    public function init()
    {
        \Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true');
        parent::init();
    }

    public function run()
    {
        $this->render('mapdigitaloctober', []);
    }

    public function getIsHasDefaultResources()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Карта Digital October');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Content;
    }
}