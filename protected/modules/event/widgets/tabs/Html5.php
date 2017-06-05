<?php
namespace event\widgets\tabs;

/**
 * Class Html
 * @package event\widgets\tabs
 *
 * @property string $TabTitle5
 * @property string $TabContent5
 */
class Html5 extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return ['TabTitle5', 'TabContent5'];
    }

    public function run()
    {
        $this->render('html', ['TabContent' => $this->TabContent5]);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return isset($this->TabTitle5) ? $this->TabTitle5 : 'Таб 5';
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