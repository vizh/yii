<?php

use application\components\console\BaseConsoleCommand;
use buduguru\models\Course;

class CourseCommand extends BaseConsoleCommand
{
    public function run($args)
    {
        $coursesData = json_decode(
            file_get_contents(Yii::app()->getParams()['BuduGuru.coursesExportUrl']),
            true
        );

        foreach ($coursesData as $courseData)
        {
            $course = Course::model()
                ->findByPk($courseData['id']);

            if ($course === null)
                $course = new Course();

            $course->Id = $courseData['id'];
            $course->Name = $courseData['name'];
            $course->Announce = $courseData['announce'];
            $course->Url = $courseData['url'];
            $course->DateStart = $courseData['dateStart'];
            $course->save();
        }
    }
}