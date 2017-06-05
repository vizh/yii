<?php
namespace event\widgets\content;

/**
 * Class Html
 * @package event\widgets\content
 *
 * @property string $HtmlContentContent
 */
class Html extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return ['HtmlContentContent'];
    }

    public function run()
    {
        echo $this->HtmlContentContent;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Произвольный контент';
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Content;
    }
}