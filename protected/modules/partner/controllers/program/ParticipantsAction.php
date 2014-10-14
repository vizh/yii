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
                'order' => '"LinkUsers"."Order", "LinkUsers"."Id" ASC'
            )
        );
        $section = \event\models\section\Section::model()->byEventId($event->Id)->byDeleted(false)->findByPk($sectionId, $criteria);
        if ($section === null)
            throw new \CHttpException(404);

        $request = \Yii::app()->getRequest();
        $form = new \partner\models\forms\program\Participant();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate()) {
            if (!empty($form->Id)) {
                $linkUser = \event\models\section\LinkUser::model()
                    ->bySectionId($section->Id)->findByPk($form->Id);
                if ($linkUser == null) {
                    $form->addError('Id', \Yii::t('app', 'Не найдена секция'));
                }
            } else {
                $linkUser = new \event\models\section\LinkUser();
                $linkUser->SectionId = $section->Id;
            }

            $form->buildModels();

            if (!$form->hasErrors()) {
                if ($form->Delete == 1) {
                    $linkUser->delete();
                    if ($form->user !== null && \event\models\section\LinkUser::model()->byEventId($event->Id)->byUserId($form->user->Id)->exists() == false) {
                        if (!empty($event->Parts)) {
                            $event->unregisterUserOnAllParts($form->user);
                        } else {
                            $event->unregisterUser($form->user);
                        }
                    }
                } else {
                    $linkUser->UserId = null;
                    $linkUser->CompanyId = null;
                    $linkUser->CustomText = null;

                    if ($form->user !== null) {
                        $linkUser->UserId = $form->user->Id;
                        if (!empty($event->Parts)) {
                            $event->registerUserOnAllParts($form->user, \event\models\Role::model()->findByPk(3));
                        } else {
                            $event->registerUser($form->user, \event\models\Role::model()->findByPk(3));
                        }
                    } elseif ($form->company !== null) {
                        $linkUser->CompanyId = $form->CompanyId;
                    } else {
                        $linkUser->CustomText = $form->CustomText;
                    }

                    $linkUser->RoleId = $form->RoleId;
                    $linkUser->Order = $form->Order;
                    $linkUser->VideoUrl = !empty($form->VideoUrl) ? $form->VideoUrl : null;
                    if (!$form->getIsEmptyReportData()) {
                        $report = $linkUser->Report;
                        if ($report == null) {
                            $report = new \event\models\section\Report();
                        }
                        $report->Url = $form->ReportUrl;
                        $report->Thesis = $form->ReportThesis;
                        $report->Title = $form->ReportTitle;
                        $report->FullInfo = $form->ReportFullInfo;
                        $report->save();
                        $linkUser->ReportId = $report->Id;
                    }
                    $linkUser->save();
                }
                $section->save();
                \Yii::app()->user->setFlash('success', \Yii::t('app', 'Информация об участниках секции успешно сохранена!'));
                $this->getController()->refresh();
            }
        }

        $this->getController()->setPageTitle(\Yii::t('app','Редактирование участников секции'));
        \Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
        $this->getController()->render('participants', array(
            'section' => $section,
            'form' => $form,
        ));
    }
}
