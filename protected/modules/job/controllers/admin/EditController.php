<?php

class EditController extends application\components\controllers\AdminMainController
{
    public function actionIndex($jobId = null)
    {
        $form = new \job\models\form\Edit();

        // Инициализация
        if ($jobId !== null) {
            $job = \job\models\Job::model()->findByPk($jobId);
            if ($job == null) {
                throw new \CHttpException(404);
            }
            $form->Title = $job->Title;
            $form->Text = $job->Text;
            $form->SalaryFrom = $job->SalaryFrom;
            $form->SalaryTo = $job->SalaryTo;
            $form->Url = $job->Url;
            $form->Visible = $job->Visible ? 1 : 0;
            $form->Category = $job->CategoryId;
            $form->Company = $job->Company->Name;
            $form->Position = $job->Position->Title;
            $jobUp = \job\models\JobUp::model()->byJobId($job->Id)->find();
            if ($jobUp !== null) {
                $form->JobUp = 1;
                $form->JobUpStartTime = \Yii::app()->dateFormatter->format('dd.MM.yyyy HH:mm', $jobUp->StartTime);
                $form->JobUpEndTime = $jobUp->EndTime !== null ? \Yii::app()->dateFormatter->format('dd.MM.yyyy HH:mm', $jobUp->EndTime) : '';
            }
        } else {
            $job = new \job\models\Job();
        }

        // Сохранение
        $request = \Yii::app()->getRequest();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate()) {
            $job->Title = $form->Title;
            $job->Text = $form->Text;
            $job->SalaryFrom = !empty($form->SalaryFrom) ? $form->SalaryFrom : null;
            $job->SalaryTo = !empty($form->SalaryTo) ? $form->SalaryTo : null;
            $job->Url = $form->Url;
            $job->Visible = $form->Visible == 1 ? true : false;
            $job->CategoryId = $form->Category;
            $job->setCompany($form->Company);
            $job->setPosition($form->Position);
            $job->save();

            $jobUp = \job\models\JobUp::model()->byJobId($job->Id)->find();
            if ($form->JobUp == 1) {
                if ($jobUp == null) {
                    $jobUp = new \job\models\JobUp();
                    $jobUp->JobId = $job->Id;
                }
                $jobUp->StartTime = \Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm:ss', $form->JobUpStartTime);
                $jobUp->EndTime = !empty($form->JobUpEndTime) ? \Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm:ss', $form->JobUpEndTime) : null;
                $jobUp->save();
            } else if ($form->JobUp == 0 && $jobUp !== null) {
                $jobUp->delete();
            }

            \Yii::app()->user->setFlash('success', 'Вакансия успешно сохранена!');
            $this->redirect(
                $this->createUrl('/job/admin/edit/index', ['jobId' => $job->Id])
            );
        }
        $this->render('index', ['form' => $form]);
    }
}
