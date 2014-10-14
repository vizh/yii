<?php
class ProgramController extends \partner\components\Controller
{
    public function actionIndex($date = null)
    {
        $event = \Yii::app()->partner->getEvent();
        if ($date == null) {
            $date = $event->getFormattedStartDate('yyyy-MM-dd');
        } else {
            $validator = new \CTypeValidator();
            $validator->type = 'date';
            $validator->dateFormat = 'yyyy-MM-dd';
            if (!$validator->validateValue($date))
                throw new CHttpException(404);
        }

        $sections = \event\models\section\Section::model()->byDate($date)->byEventId($event->Id)
            ->byDeleted(false)->findAll();
        $this->setPageTitle(\Yii::t('app', 'Программа'));
        $this->render('index', array('event' => $event, 'sections' => $sections, 'date' => $date));
    }

    public function actions()
    {
        return array(
            'section' => '\partner\controllers\program\SectionAction',
            'participants' => '\partner\controllers\program\ParticipantsAction',
            'hall' => '\partner\controllers\program\HallAction'
        );
    }
}
