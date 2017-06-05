<?php
namespace event\widgets\tabs;

/**
 * Class Html
 * @package event\widgets\tabs
 *
 * @property string $TabTitle2
 * @property string $TabContent2
 */
class Html2 extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return ['TabTitle2', 'TabContent2'];
    }

    public function run()
    {
        $this->render('html', ['TabContent' => $this->TabContent2]);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return isset($this->TabTitle2) ? $this->TabTitle2 : 'Таб 2';
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Tabs;
    }

    protected function getInternalAdminPanel()
    {
        return new \event\widgets\panels\tabs\Html($this);
    }
}