<?php
namespace event\widgets\tabs;

/**
 * Class Html
 * @package event\widgets\tabs
 *
 * @property string $TabTitle
 * @property string $TabContent
 */
class Html extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return ['TabTitle', 'TabContent'];
    }

    public function run()
    {
        $this->render('html', ['TabContent' => $this->TabContent]);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return isset($this->TabTitle) ? $this->TabTitle : 'Таб 1';
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Tabs;
    }
}