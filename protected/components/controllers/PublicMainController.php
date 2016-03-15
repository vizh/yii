<?php
namespace application\components\controllers;

class PublicMainController extends MainController
{
    public $layout = '//layouts/public';
    public $bodyId = 'index-page';

    public function filters()
    {
        $filters = parent::filters();
        return array_merge(
            $filters,
            array(
                'setLanguage'
            )
        );
    }

    /**
     * @param \CFilterChain $filterChain
     */
    public function filterSetLanguage($filterChain)
    {
        $this->setLanguage();
        $filterChain->run();
    }

    protected function setLanguage()
    {
        $lang = \Yii::app()->getRequest()->getParam('lang');
        $lang = in_array($lang, \Yii::app()->params['Languages']) ? $lang : null;
        if ($lang !== null) {
            $cookie = new \CHttpCookie('lang', $lang, ['expire' => time() + 180 * 24 * 60 * 60]);
            \application\components\Cookie::Set($cookie);

            $cookie = new \CHttpCookie('langCreationTime', time(), ['expire' => time() + 180 * 24 * 60 * 60]);
            \application\components\Cookie::Set($cookie);

            unset($_GET['lang']);
            if (!\Yii::app()->user->isGuest && \Yii::app()->user->getCurrentUser()->Language != $lang) {
                \Yii::app()->user->getCurrentUser()->Language = $lang;
                \Yii::app()->user->getCurrentUser()->save();
            }
            $this->redirect($this->createUrl('/' . $this->route, $_GET));
        }

        $lang = isset(\Yii::app()->getRequest()->cookies['lang']) ? \Yii::app()->getRequest()->cookies['lang']->value : null;
        $lang = in_array($lang, \Yii::app()->params['Languages']) ? $lang : null;
        $langCreationTime = isset(\Yii::app()->getRequest()->cookies['langCreationTime']) ? (int)\Yii::app()->getRequest()->cookies['langCreationTime']->value : null;
        if (!\Yii::app()->user->isGuest || !\Yii::app()->tempUser->isGuest) {
            $user = !\Yii::app()->user->isGuest ? \Yii::app()->user->getCurrentUser() : \Yii::app()->tempUser->getCurrentUser();
            if ($lang !== null &&
                ($user->Language == null || ($langCreationTime != null && time() - $langCreationTime < 60 * 60))
            ) {
                $user->Language = $lang;
                $user->save();
            } elseif ($user->Language != null) {
                $lang = $user->Language;
                $cookie = new \CHttpCookie('lang', $lang, ['expire' => time() + 180 * 24 * 60 * 60]);
                \application\components\Cookie::Set($cookie);
            }
        }

        if ($lang !== null) {
            \Yii::app()->setLanguage($lang);
        }
    }

    protected function initResources()
    {
        \Yii::app()->getClientScript()->registerPackage('runetid.application');
        parent::initResources();
    }
}
