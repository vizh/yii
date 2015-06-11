<?php
namespace partner\controllers\program;

use application\helpers\Flash;
use event\models\section\LinkUser;
use event\models\section\Section;
use partner\components\Action;

class ParticipantsAction extends Action
{
    public function run($id)
    {
        $event = \Yii::app()->partner->getEvent();
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'LinkUsers' => [
                'together' => false,
                'order' => '"LinkUsers"."Order", "LinkUsers"."Id" ASC'
            ]
        ];
        $section = Section::model()->byEventId($event->Id)->byDeleted(false)->findByPk($id, $criteria);
        if ($section === null) {
            throw new \CHttpException(404);
        }

        $request = \Yii::app()->getRequest();
        $form = new \partner\models\forms\program\Participant();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate()) {
            if (!empty($form->Id)) {
                $linkUser = LinkUser::model()->bySectionId($section->Id)->findByPk($form->Id);
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
                    $linkUser->Deleted = true;
                    $linkUser->save();

                    if ($form->user !== null && !LinkUser::model()->byEventId($event->Id)->byUserId($form->user->Id)->byDeleted(false)->exists()) {
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
                Flash::setSuccess(\Yii::t('app', 'Информация об участниках секции успешно сохранена!'));
                $this->getController()->refresh();
            }
        }

        \Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
        $this->getController()->render('participants', [
            'section' => $section,
            'form' => $form,
        ]);
    }
}
