<?php
namespace user\controllers\edit;

class ProfessionalInterestsAction extends \CAction
{
    public function run()
    {
        $user = \Yii::app()->user->getCurrentUser();
        $request = \Yii::app()->getRequest();
        $form = new \user\models\forms\edit\ProfessionalInterests();
        if ($request->getIsPostRequest()) {
            $form->attributes = $request->getParam(get_class($form));
            $professionalInterests = \application\models\ProfessionalInterest::model()->findAll();
            foreach ($professionalInterests as $profInteres) {
                $linkProfessionalInterest = \user\models\LinkProfessionalInterest::model()
                    ->byUserId($user->Id)->byProfessionalInterestId($profInteres->Id)->find();
                if ($linkProfessionalInterest == null && $form->{$profInteres->Code} == 1) {
                    $linkProfessionalInterest = new \user\models\LinkProfessionalInterest();
                    $linkProfessionalInterest->ProfessionalInterestId = $profInteres->Id;
                    $linkProfessionalInterest->UserId = $user->Id;
                    $linkProfessionalInterest->save();
                } else if ($linkProfessionalInterest !== null && empty($form->attributes[$profInteres->Code])) {
                    $linkProfessionalInterest->delete();
                }
            }
            \Yii::app()->user->setFlash('success', \Yii::t('app', 'Ваши профессиональные интересы успешно сохранены!'));
            $this->getController()->refresh();
        } else {
            foreach ($user->LinkProfessionalInterests as $linkProfInteres) {
                $form->{$linkProfInteres->ProfessionalInterest->Code} = 1;
            }
        }
        $this->getController()->bodyId = 'user-account';
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование профиля'));
        $this->getController()->render('profinterests', ['form' => $form, 'user' => $user]);
    }
}
