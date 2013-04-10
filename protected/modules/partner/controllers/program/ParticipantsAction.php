<?php
namespace partner\controllers\program;

class ParticipantsAction extends \partner\components\Action
{
  public function run($sectionId)
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
          if (\event\models\section\LinkUser::model()->byEventId($event->Id)->byUserId($user->Id)->exists() == false)
          {
            if (!empty($event->Parts))
            {
              $event->unregisterUserOnAllParts($user);
            }
            else
            {
              $event->unregisterUser($user);
            }
          }
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
          if (!empty($event->Parts))
          {
            $event->registerUserOnAllParts($user, \event\models\Role::model()->findByPk(3));
          }
          else 
          {
            $event->registerUser($user, \event\models\Role::model()->findByPk(3));
          }
        }
        \Yii::app()->user->setFlash('success', \Yii::t('app', 'Информация об участниках секции успешно сохранена!'));
        $this->getController()->refresh();
      }
    }
    
    $this->getController()->getPageTitle(\Yii::t('app','Программа'));
    $this->getController()->render('participants', array(
      'section' => $section, 
      'form' => $form,
    ));
  }
}
