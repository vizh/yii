<?php
namespace partner\controllers\program;

class HallAction extends \partner\components\Action
{

  private $forms = [];
  private $locale;

  public function run()
  {
    $request = \Yii::app()->getRequest();
    $this->locale = $request->getParam('locale', \Yii::app()->sourceLanguage);

    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Order" ASC, "t"."Title" ASC';
    $halls = \event\models\section\Hall::model()->byEventId($this->getEvent()->Id)
        ->byDeleted(false)->findAll($criteria);

    foreach ($halls as $hall)
    {
      $hall->setLocale($this->locale);
      $form = new \partner\models\forms\program\Hall($this->getEvent());
      $form->Id = $hall->Id;
      $form->Title = $hall->Title;
      $form->Order = $hall->Order;
      $this->forms[] = $form;
    }

    if ($request->getIsPostRequest())
    {
      $this->processForm();
    }

    $this->getController()->setPageTitle(\Yii::t('app', 'Список залов'));
    $this->getController()->render('hall', ['forms' => $this->forms, 'locale' => $this->locale]);
  }

  private function processForm()
  {
    $request = \Yii::app()->getRequest();
    $form = new \partner\models\forms\program\Hall($this->getEvent());
    $form->attributes = $request->getParam(get_class($form));
    if ($form->validate())
    {
      $hall = \event\models\section\Hall::model()->byEventId($this->getEvent()->Id)->findByPk($form->Id);
      $hall->setLocale($this->locale);
      if ($hall == null)
        throw new \CHttpException(404);

      if ($form->Delete == 1)
      {
        $hasLinks = \event\models\section\LinkHall::model()->byHallId($hall->Id)->exists();
        if (!$hasLinks)
        {
            $hall->Deleted = true;
            $hall->save();
          $this->getController()->refresh();
        }
      }

      $hall->Title = $form->Title;
      $hall->Order = $form->Order;
      $hall->save();
      \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Информация о залах успешно сохранена'));
      $this->getController()->refresh();
    }
    else
    {
      foreach ($this->forms as $key => $f)
      {
        if ($f->Id == $form->Id)
        {
          $this->forms[$key] = $form;
          break;
        }
      }
    }
  }
} 