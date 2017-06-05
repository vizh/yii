<?php
namespace event\controllers\admin\edit;

class WidgetAction extends \CAction
{
    public function run($widget, $eventId)
    {
        $event = \event\models\Event::model()->findByPk($eventId);
        $widget = $this->getController()->createWidget($widget, ['event' => $event]);
        if ($widget->getAdminPanel() == null) {
            throw new \CHttpException(404);
        }

        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            if ($widget->getAdminPanel()->process()) {
                $this->getController()->refresh();
            }
        }

        $this->getController()->setPageTitle(\Yii::t('app', 'Настройка виджета &laquo;{widget}&raquo; для мероприятия &laquo;{event}&raquo;',
            ['{widget}' => $widget->getTitle(), '{event}' => $event->Title]
        ));
        $this->getController()->render('widget', ['widget' => $widget]);
    }
}
