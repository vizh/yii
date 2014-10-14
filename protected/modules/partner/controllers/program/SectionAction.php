<?php
namespace partner\controllers\program;

class SectionAction extends \partner\components\Action
{
  private $locale;

  public function run($sectionId = null)
  {
    $request = \Yii::app()->getRequest();
    $form = new \partner\models\forms\program\Section();
    $event = \Yii::app()->partner->getEvent();
    $this->locale = \Yii::app()->sourceLanguage;
    if ($sectionId == null)
    {
      $section = new \event\models\section\Section();
      $section->EventId = $event->Id;
    }
    else
    {
      $this->locale = \Yii::app()->getRequest()->getParam('locale', $this->locale);
      $section = \event\models\section\Section::model()->byEventId($event->Id)->byDeleted(false)->findByPk($sectionId);
      if ($section == null)
      {
        throw new \CHttpException(404);
      }
      $section->setLocale($this->locale);
      $form->Title = $section->Title;
      $form->Info = $section->Info;
      $form->Date = \Yii::app()->dateFormatter->format('yyyy-MM-dd', $section->StartTime);
      $form->TimeStart = \Yii::app()->dateFormatter->format('HH:mm', $section->StartTime);
      $form->TimeEnd = \Yii::app()->dateFormatter->format('HH:mm', $section->EndTime);
      $form->Type = $section->TypeId;
      foreach($section->LinkHalls as $linkHall)
      {
        $form->Hall[] = $linkHall->HallId;
      }
    }
   
    if ($request->getIsPostRequest())
    {
      $form->attributes = $request->getParam(get_class($form));
      if ($form->validate())
      {
        $section->Title = $form->Title;
        $section->StartTime = $form->Date.' '.$form->TimeStart;
        $section->EndTime = $form->Date.' '.$form->TimeEnd;
        $section->Info = $form->Info;
        $section->TypeId = $form->Type;
        $section->save();

        // Сохранение атрибутов
        foreach ($form->getAttributeList($event, $section) as $attrName => $attrValue)
        {
          $section->setSectionAttribute($attrName, $form->Attribute[$attrName]);
        }

        // Сохранение залов
        if (!empty($form->Hall))
        {
          foreach ($event->Halls as $hall)
          {
            $linkHall = \event\models\section\LinkHall::model()
              ->byHallId($hall->Id)->bySectionId($section->Id)->find();

            if (in_array($hall->Id, $form->Hall) && $linkHall == null)
            {
              $section->setHall($hall);
            }
            else if (!in_array($hall->Id, $form->Hall) && $linkHall !== null) 
            {
              $linkHall->delete();
            }
          }
        }

        // Добавление нового зала
        if (!empty($form->HallNew))
        {
          $hall = new \event\models\section\Hall();
          $hall->Title = $form->HallNew;
          $hall->EventId = $event->Id;
          $hall->save();
          $section->setHall($hall);
        }

        // Добавление нового атрибута
        if (!empty($form->AttributeNew['Name']))
        {
          $attribute = new \event\models\section\Attribute();
          $attribute->Name = $form->AttributeNew['Name'];
          $attribute->Value = $form->AttributeNew['Value'];
          $attribute->SectionId = $section->Id;
          $attribute->save();
        }
        
        \Yii::app()->user->setFlash('success', \Yii::t('app','Информация о секции успешно сохранена!'));
        $this->getController()->redirect(
          $this->getController()->createUrl('/partner/program/section', array('sectionId' => $section->Id, 'locale' => $this->locale))
        );
      }
    }
    $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование секции'));
    $this->getController()->render('section', array(
      'form' => $form,
      'event' => $event,
      'section' => $section,
      'locale' => $this->locale
    ));
  }
}
