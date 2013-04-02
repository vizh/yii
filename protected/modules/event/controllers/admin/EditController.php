<?php
class EditController extends \application\components\controllers\AdminMainController
{
  public function actionIndex($eventId = null)
  {
    $form = new \event\models\forms\admin\EditForm();
    if ($eventId !== null)
    {
      $event = \event\models\Event::model()->findByPk($eventId);
      if ($event == null)
      {
        throw new CHttpException(404);
      }
      
      foreach ($event->attributes as $attribute => $value)
      {
        if (property_exists($form, $attribute))
        {
          $form->$attribute = $value;
        }
      } 
      $form->ProfInterest = \CHtml::listData($event->LinkProfessionalInterests, 'Id', 'ProfessionalInterestId');
    }
    else 
    {
      $event = new \event\models\Event();
    }
    
    
    $request = \Yii::app()->getRequest();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      // Сохранение мероприятия
      foreach ($event->attributes as $attribute => $value)
      {
        if (property_exists($form, $attribute))
        {
          $event->$attribute = $form->$attribute;
        }
      } 
      $event->save();
      
      // Сохранение виджетов
      foreach ($form->Widgets as $class => $params)
      {
        $eventWidget = \event\models\Widget::model()->byEventId($event->Id)->byName($class)->find();
        if ($eventWidget == null && $params['Activated'] == 1)
        {
          $eventWidget = new \event\models\Widget();
          $eventWidget->EventId = $event->Id;
          $eventWidget->Name  = $class;
          $eventWidget->Order = $params['Order'];
          $eventWidget->save();
        }
        else if ($eventWidget !== null && $params['Activated'] == 0)
        {
          $eventWidget->remove();
        }
        else if ($eventWidget !== null && $params['Activated'] == 1)
        {
          $eventWidget->Order = $params['Order'];
          $eventWidget->save();
        }
      }
      
      // Сохранение проф. интересов
      foreach (\application\models\ProfessionalInterest::model()->findAll() as $profInterest)
      {
        $linkProfInterest = \event\models\LinkProfessionalInterest::model()
          ->byEventId($eventId)->byInteresId($profInteres->Id)->find();
        
        if (in_array($profInterest->Id, $form->ProfInterest) 
          && $linkProfInterest == null)
        {
          $linkProfInterest = new \event\models\LinkProfessionalInterest();
          $linkProfInterest->ProfessionalInterestId = $profInterest->Id;
          $linkProfInterest->EventId = $event->Id;
          $linkProfInterest->save();
        }
        else if (!in_array($profInterest->Id, $form->ProfInterest)
          && $linkProfInterest !== null)
        {
          $linkProfInterest->remove();
        }
      }
    }
    
    $widgetFactory = new \event\components\WidgetFactory();
    $widgets = new \stdClass();
    $widgets->All = $widgetFactory->getWidgets($event);
    foreach ($event->Widgets as $widget)
    {
      $widgets->Used[$widget->Name] = $widget;
    }
    \Yii::app()->clientScript->registerPackage('runetid.ckeditor');
    $this->render('index', array(
      'form'    => $form, 
      'event'   => $event, 
      'widgets' => $widgets)
    );
  }
}
