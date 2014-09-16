<?php
use application\components\controllers\PublicMainController;
use company\models\Company;
use raec\models\Brief;
use raec\models\BriefLinkCompany;
use raec\models\BriefLinkUser;
use raec\models\BriefUserRole;
use raec\models\forms\brief\About;
use raec\models\forms\brief\Resume;
use raec\models\forms\brief\Users;
use user\models\User;

class BriefController extends PublicMainController
{
    const DATA_SESSION_NAME = 'RaecBrief';
    const STEP_SESSION_NAME = 'RaecBriefStep';

    protected function beforeAction($action)
    {
        if ($action->getId() != $this->getSteps()[0]) {
            $step = \Yii::app()->getSession()->get(self::STEP_SESSION_NAME, 0);
            if (array_search($action->getId(), $this->getSteps()) > $step || \Yii::app()->getUser()->getIsGuest()) {
                $this->redirect('/raec/brief/'.$this->getSteps()[0]);
            }
        }
        $this->setPageTitle(\Yii::t('app', 'Анкета на вступление в Ассоциацию'));
        return parent::beforeAction($action);
    }


    public function getSteps()
    {
        return ['index','about','resume','users','final'];
    }

    public function getStepTitle($step)
    {
        $titles = [
            'index'  => \Yii::t('app', '1. Общая информация'),
            'about'  => \Yii::t('app', '2. Об организации'),
            'resume' => \Yii::t('app', '3. Дополнительная информация'),
            'users'  => \Yii::t('app', '4. Сотрудники'),
            'final'  => \Yii::t('app', '5. Завершение')
        ];

        if (array_key_exists($step, $titles)) {
            return $titles[$step];
        }
        return null;
    }


    public function actionIndex()
    {
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $this->redirectToNextAction();
        }
        $this->render('index');
    }

    public function actionAbout()
    {
        $form = new About();
        $this->fillFormFromSession($form);

        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form->attributes = $request->getParam(get_class($form));
            if ($form->validate()) {
                $this->saveFormInSession($form);
                $this->redirectToNextAction();
            }
        }

        \Yii::app()->getClientScript()->registerPackage('runetid.bootstrap-datepicker');
        $this->render('about', ['modelForm' => $form]);
    }

    public function actionResume()
    {
        $form = new Resume();
        $this->fillFormFromSession($form);
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form->attributes = $request->getParam(get_class($form));
            if ($form->validate()) {
                $this->saveFormInSession($form);
                $this->redirectToNextAction();
            }
        }
        $this->render('resume', ['modelForm' => $form]);
    }

    public function actionUsers()
    {
        $form = new Users();
        $this->fillFormFromSession($form);
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form->attributes = $request->getParam(get_class($form));
            if ($form->validate()) {
                $this->saveFormInSession($form);
                $this->redirectToNextAction();
            }
        }
        $this->render('users', ['modelForm' => $form]);
    }

    public function actionFinal()
    {
        $forms = [
            '\raec\models\forms\brief\About',
            '\raec\models\forms\brief\Resume',
            '\raec\models\forms\brief\Users'
        ];
        $data  = [];
        foreach ($forms as $name) {
            $form = new $name();
            $this->fillFormFromSession($form);
            if (!$form->validate())
                throw new \CHttpException(500);

            $data = array_merge($data, $form->getAttributes());
        }

        $brief = new Brief();
        $brief->UserId = \Yii::app()->getUser()->getId();
        $brief->Data = json_encode($data);
        $brief->save();

        if (!empty($data['CompanyLabel']) && empty($data['CompanyId'])) {
            $company = Company::create($data['CompanyLabel']);
        } else {
            $company = Company::model()->findByPk($data['CompanyId']);
        }
        if ($company == null)
            throw new \CHttpException(500);

        $linkCompany = new BriefLinkCompany();
        $linkCompany->CompanyId = $company->Id;
        $linkCompany->BriefId = $brief->Id;
        $linkCompany->Primary = true;
        $linkCompany->save();

        foreach ($data['CompanySynonyms'] as $value) {
            if (!empty($value['Label']) && empty($value['Id'])) {
                $company = Company::create($value['Label']);
            } else {
                $company = Company::model()->findByPk($value['Id']);
            }
            if ($company == null)
                throw new \CHttpException(500);

            $linkCompany = new BriefLinkCompany();
            $linkCompany->CompanyId = $company->Id;
            $linkCompany->BriefId = $brief->Id;
            $linkCompany->save();
        }

        foreach ($data['Users'] as $value) {
            $user = User::model()->byRunetId($value['RunetId'])->find();
            $role = BriefUserRole::model()->findByPk($value['RoleId']);
            if ($user == null || $role == null)
                throw new \CHttpException(500);

            $linkUser = new BriefLinkUser();
            $linkUser->BriefId = $brief->Id;
            $linkUser->UserId  = $user->Id;
            $linkUser->RoleId  = $role->Id;
            $linkUser->save();
        }
        $this->clearSession();
        $this->render('final');
    }

    public function render($view, $data = null, $return = false)
    {
        $content = $this->renderPartial($view, $data, true);
        return parent::render('main', ['content' => $content], $return);
    }

    /**
     * @param \CFormModel $form
     */
    private function saveFormInSession($form)
    {
        $data = \Yii::app()->getSession()->get(self::DATA_SESSION_NAME, []);
        $data[get_class($form)] = $form->getAttributes();
        \Yii::app()->getSession()->add(self::DATA_SESSION_NAME, $data);
    }

    /**
     * @param \CFormModel $form
     */
    private function fillFormFromSession($form)
    {
        $data = \Yii::app()->getSession()->get(self::DATA_SESSION_NAME, []);
        $key  = get_class($form);
        if (array_key_exists($key, $data)) {
            $form->setAttributes($data[$key]);
        }
    }

    private function clearSession()
    {
        \Yii::app()->getSession()->remove(self::DATA_SESSION_NAME);
        \Yii::app()->getSession()->remove(self::STEP_SESSION_NAME);
    }

    private function redirectToNextAction()
    {
        $key = array_search($this->getAction()->getId(), $this->getSteps());
        if ($key === false)
            throw new CHttpException(500);

        $key = $key+1;
        \Yii::app()->getSession()->add(self::STEP_SESSION_NAME, $key);
        $this->redirect(['/raec/brief/' . $this->getSteps()[$key]]);
    }
} 