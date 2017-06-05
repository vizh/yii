<?php

/**
 * Created by IntelliJ IDEA.
 * User: Alaris
 * Date: 11/28/13
 * Time: 4:14 PM
 * To change this template use File | Settings | File Templates.
 */
class ContentController extends \application\components\controllers\PublicMainController
{
    public function actionHr()
    {
        $this->bodyId = 'about-page';
        $this->render('hr');
    }
}