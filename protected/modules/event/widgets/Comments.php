<?php
namespace event\widgets;

use event\components\Widget;
use event\components\WidgetPosition;

/**
 * Class Comments
 * @package event\widgets
 */
class Comments extends Widget
{
    public function run()
    {
        $this->render('comments', []);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Комментарии');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return WidgetPosition::Content;
    }

    /**
     * @return bool
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
        \Yii::app()->getClientScript()->registerMetaTag('201234113248910', null, null, ['property' => 'fb:app_id']);
    }

}
