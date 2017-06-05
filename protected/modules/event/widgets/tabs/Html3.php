<?php
namespace event\widgets\tabs;

/**
 * Class Html
 * @package event\widgets\tabs
 *
 * @property string $TabTitle3
 * @property string $TabContent3
 */
class Html3 extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return ['TabTitle3', 'TabContent3'];
    }

    public function run()
    {
        $this->render('html', ['TabContent' => $this->TabContent3]);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return isset($this->TabTitle3) ? $this->TabTitle3 : 'Таб 3';
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