<?php

class SpecialController extends \application\components\controllers\PublicMainController
{
    public function actionChildsafety2013()
    {
        $this->setPageTitle('Международная конференция по обеспечению  детской безопасности и цифровой грамотности в Интернете / RUNET-ID');
        $this->bodyId = 'about-page';
        $this->render('childsafety2013');
    }

    public function actionResearch2012()
    {
        $this->setPageTitle('Исследование «Экономика Рунета 2011-2012» / RUNET-ID');
        $this->bodyId = 'about-page';
        $this->render('research2012');
    }
}
