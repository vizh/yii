<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.06.2015
 * Time: 17:59
 */

namespace partner\controllers\program;

use event\models\section\Section;
use partner\components\Action;

class IndexAction extends Action
{
    public function run($date = null)
    {
        $event = $this->getEvent();
        if ($date == null) {
            $date = $event->getFormattedStartDate('yyyy-MM-dd');
        } else {
            $validator = new \CTypeValidator();
            $validator->type = 'date';
            $validator->dateFormat = 'yyyy-MM-dd';
            if (!$validator->validateValue($date)) {
                throw new CHttpException(404);
            }
        }

        $sections = Section::model()->byDate($date)->byEventId($event->Id)->byDeleted(false)->findAll();
        $this->getController()->render('index', [
            'event' => $event,
            'sections' => $sections,
            'date' => $date,
            'intervals' => $this->getIntervals($sections)
        ]);
    }

    /**
     * @param Section[] $sections
     * @return array
     */
    public function getIntervals($sections)
    {
        $formatter = \Yii::app()->getDateFormatter();

        $intervals = [];
        foreach ($sections as $section) {
            $intervals[] = $formatter->format('HH:mm', $section->StartTime);
            $intervals[] = $formatter->format('HH:mm', $section->EndTime);
        }
        $intervals = array_unique($intervals);
        sort($intervals);
        return $intervals;
    }
}