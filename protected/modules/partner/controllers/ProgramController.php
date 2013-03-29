<?php
class ProgramController extends \partner\components\Controller
{
  public function actionIndex($date = null)
  {
    $event = \Yii::app()->partner->getEvent();
    if ($date == null)
    {
      $date = $event->getFormattedStartDate('yyyy-MM-dd');
    }  
    else 
    {
      $validator = new \CTypeValidator();
      $validator->type = 'date';
      $validator->dateFormat = 'yyyy-MM-dd';
      if (!$validator->validateValue($date))
        throw new CHttpException(404);
    }
    
    $sections = \event\models\section\Section::model()->byDate($date)->findAll();
    $this->setPageTitle(\Yii::t('app', 'Программа'));
    $this->render('index', array('event' => $event, 'sections' => $sections, 'date' => $date));
  }
   
  public function actionParticipants($sectionId)
  {
    $event = \Yii::app()->partner->getEvent();
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'LinkUsers' => array(
        'together' => false,
        'order' => '"LinkUsers"."Order" DESC, "LinkUsers"."Id" ASC'
      )
    );
    $section = \event\models\section\Section::model()->byEventId($event->Id)->findByPk($sectionId, $criteria);
    if ($section == null) 
    {
      throw new \CHttpException(404);
    }

    $request = \Yii::app()->getRequest();
    $form = new \partner\models\forms\program\Participant();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      if (!empty($form->Id))
      {
        $linkUser = \event\models\section\LinkUser::model()
          ->bySectionId($section->Id)->findByPk($form->Id);
        if ($linkUser == null)
        {
          $form->addError('Id', \Yii::t('app', 'Не найдена секция'));
        }
      }
      else
      {
        $linkUser = new \event\models\section\LinkUser();
        $linkUser->SectionId = $section->Id;
      }
      $user = \user\models\User::model()->byRunetId($form->RunetId)->find();
      if ($user == null)
      {
        $form->addError('', \Yii::t('app', 'Не найден пользователь с RUNET&ndash;ID:{RunetId}', array('RunetId' => $form->RunetId)));
      }
      
      if (!$form->hasErrors())
      {
        if ($form->Delete == 1)
        {
          $linkUser->delete();
        }
        else
        {
          $linkUser->UserId = $user->Id;
          $linkUser->RoleId = $form->RoleId;
          $linkUser->Order  = $form->Order;
          if (!empty($form->ReportTitle) || !empty($form->ReportThesis) || !empty($form->ReportUrl))
          {
            $report = $linkUser->Report;
            if ($report == null)
            {
              $report = new \event\models\section\Report();
            }
            $report->Url = $form->ReportUrl;
            $report->Thesis = $form->ReportThesis;
            $report->Title = $form->ReportTitle;
            $report->save();
            $linkUser->ReportId = $report->Id;
          }
          $linkUser->save();
        }
        \Yii::app()->user->setFlash('success', \Yii::t('app', 'Информация об участниках секции успешно сохранена!'));
        $this->refresh();
      }
    }
    
    
    
    $this->render('participants', array(
      'section' => $section, 
      'form' => $form,
    ));
  }
  
  public function actions()
  {
    return array(
      'section' => '\partner\controllers\program\SectionAction'
    );
  }
}
