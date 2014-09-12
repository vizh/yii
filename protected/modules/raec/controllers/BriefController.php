<?php
use application\components\controllers\PublicMainController;
use raec\models\forms\brief\About;

class BriefController extends PublicMainController
{
    const SESSION_NAME = 'RaecBrief';
    private static $STEPS = ['index','about','resume'];


    public function actionIndex()
    {

    }

    public function actionAbout()
    {
        $form = new About();
        $request = \Yii::app()->getRequest();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate()) {
            $this->saveFormInSession($form);
            //$this->refresh();
            //$this->nextAction();
        }

        \Yii::app()->getClientScript()->registerPackage('runetid.bootstrap-datepicker');
        $this->render('about', ['modelForm' => $form]);
    }


    public function render($view, $data = null, $return = false)
    {
        $content = $this->renderPartial($view, $data, true);
        return parent::render('main', ['content' => $content], $return);
    }

    private function saveFormInSession($form)
    {
        $result = \Yii::app()->getSession()->get(self::SESSION_NAME, []);
        $result[get_class($form)] = serialize($form);
        \Yii::app()->getSession()->add(self::SESSION_NAME, $result);
    }

    private function nextAction()
    {
        $key = array_search($this->getAction()->getId(), self::$STEPS);
        if ($key === false)
            throw new CHttpException(500);

        $this->redirect(['/raec/brief/'.self::$STEPS[$key+1]]);
    }
} 