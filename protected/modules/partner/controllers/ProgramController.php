<?php

use partner\components\Controller;

class ProgramController extends Controller
{
    public function actions()
    {
        return [
            'index' => '\partner\controllers\program\IndexAction',
            'section' => '\partner\controllers\program\SectionAction',
            'participants' => '\partner\controllers\program\ParticipantsAction',
            'hall' => '\partner\controllers\program\HallAction',
            'deletesection' => '\partner\controllers\program\DeleteSectionAction'
        ];
    }
}
