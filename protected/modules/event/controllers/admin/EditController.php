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
      if ($event->LinkSite !== null)
      {
        $form->SiteUrl = (string) $event->LinkSite->Site;
      }
      
      $form->Address->attributes = $event->getContactAddress()->attributes;
    }
    else 
    {
      $event = new \event\models\Event();
    }
    
    
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $form->attributes = $request->getParam(get_class($form));
      $form->Logo = \CUploadedFile::getInstance($form, 'Logo');
      if ($form->validate())
      {        
        // Сохранение мероприятия
        foreach ($event->attributes as $attribute => $value)
        {
          if (property_exists($form, $attribute))
          {
            if ($attribute == 'IdName')
            {
              //$event->getLogo()->rebase($form->$attribute);
            }
            $event->$attribute = $form->$attribute;
          }
        } 
        $event->save();
        
        // Сохранение адреса
        $address = $event->getContactAddress();
        if ($address == null)
        {
          $address = new \contact\models\Address();
        }
        $address->RegionId = $form->Address->RegionId;
        $address->CountryId = $form->Address->CountryId;
        $address->CityId = $form->Address->CityId;
        $address->Street = $form->Address->Street;
        $address->House = $form->Address->House;
        $address->Building = $form->Address->Building;
        $address->Wing = $form->Address->Wing;
        $address->Place = $form->Address->Place;
        $address->save();
        $event->setContactAddress($address);
        
        // Сохранение сайта
        if (!empty($form->SiteUrl))
        {
          $parseUrl = parse_url($form->SiteUrl);
          $event->setContactSite($parseUrl['host'], ($parseUrl['scheme'] == 'https' ? true : false));
        }
        
        // Сохранение логотипа
        if ($form->Logo !== null)
        {
          $event->getLogo()->save($form->Logo);
        }
        
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
            $eventWidget->delete();
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
        
        \Yii::app()->user->setFlash('success', \Yii::t('app', 'Мероприятие успешно сохранено'));
        $this->refresh();
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
