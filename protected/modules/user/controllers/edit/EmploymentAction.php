<?php
namespace user\controllers\edit;

class EmploymentAction extends \CAction
{
    public function run()
    {
        $user = \Yii::app()->user->getCurrentUser();
        $request = \Yii::app()->getRequest();
        $form = new \user\models\forms\edit\Employments();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest()) {
            if ($form->validate()) {
                $success = true;
                foreach ($form->Employments as $formEmployment) {
                    try {
                        if (!empty($formEmployment->Id)) {
                            $employment = \user\models\Employment::model()->byUserId($user->Id)->findByPk($formEmployment->Id);
                            if ($employment == null) {
                                throw new \CHttpException(500);
                            }
                            if ($formEmployment->Company !== $employment->Company->Name) {
                                $employment->chageCompany($formEmployment->Company);
                            }
                        } else {
                            $employment = $user->setEmployment($formEmployment->Company, $formEmployment->Position);
                        }

                        if ($formEmployment->Delete == 1) {
                            $employment->delete();
                        } else {
                            $employment->Position = $formEmployment->Position;
                            $employment->StartMonth = !empty($formEmployment->StartMonth) ? $formEmployment->StartMonth : null;
                            $employment->EndMonth = !empty($formEmployment->EndMonth) ? $formEmployment->EndMonth : null;
                            $employment->StartYear = !empty($formEmployment->StartYear) ? $formEmployment->StartYear : null;
                            $employment->EndYear = !empty($formEmployment->EndYear) ? $formEmployment->EndYear : null;
                            $employment->Primary = $formEmployment->Primary == 1 && empty($formEmployment->EndYear) ? true : false;
                            $employment->save();
                        }
                    } catch (\application\components\Exception $e) {
                        $formEmployment->addError('Company', \Yii::t('app', 'Вы ввели некорректное название компании'));
                        $success = false;
                    }
                }

                if ($success) {
                    \Yii::app()->getDb()->createCommand('SELECT "UpdateEmploymentPrimary"(:UserId)')->execute([
                        'UserId' => $user->Id
                    ]);
                    \Yii::app()->user->setFlash('success', \Yii::t('app', 'Карьера успешно сохранена!'));
                    $this->getController()->refresh();
                }
            }
        } else {
            foreach ($user->Employments as $employment) {
                $formEmployment = new \user\models\forms\Employment();
                $formEmployment->attributes = [
                    'Id' => $employment->Id,
                    'Company' => (!empty($employment->Company->FullName) ? $employment->Company->FullName : $employment->Company->Name),
                    'Position' => $employment->Position,
                    'StartMonth' => $employment->StartMonth,
                    'StartYear' => $employment->StartYear,
                    'EndMonth' => $employment->EndMonth,
                    'EndYear' => $employment->EndYear,
                    'Primary' => $employment->Primary ? 1 : 0
                ];
                $form->Employments[] = $formEmployment;
            }
        }

        $this->getController()->bodyId = 'user-account';
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование профиля'));
        $this->getController()->render('employment', ['form' => $form]);
    }
}
