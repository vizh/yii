<?php
namespace education\controllers;

use application\components\controllers\AjaxController as TraitAjaxController;
use application\components\controllers\MainController;
use education\models\Faculty;
use education\models\University;

class AjaxController extends MainController
{
    use TraitAjaxController;

    /**
     * Поиск по университетам
     * @param string $term
     * @param int $cityId
     */
    public function actionUniversities($term, $cityId = null)
    {
        $result = [];
        $model = University::model()->byName($term)->limit(10)->orderBy(['"t"."Name"' => SORT_ASC]);
        if (!empty($cityId)) {
            $model->byCityId($cityId);
        }
        $universities = $model->findAll();
        foreach ($universities as $university) {
            $result[] = $this->universityDataBuilder($university);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function actionFaculties($term, $universityId)
    {
        $result = [];
        if (!empty($universityId)) {
            $criteria = new \CDbCriteria();
            $criteria->order = '"t"."Name" ASC';
            $criteria->limit = 10;
            $faculties = Faculty::model()->byUniversityId($universityId)->byName($term)->findAll($criteria);
            foreach ($faculties as $faculty) {
                $result[] = $this->facultyDataBuilder($faculty);
            }
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     *
     * @param University $university
     * @return \stdClass
     */
    private function universityDataBuilder($university)
    {
        $result = new \stdClass();
        $result->UniversityId = $university->Id;
        $result->label = $result->value = $result->Name = $university->Name;
        return $result;
    }

    /**
     *
     * @param Faculty $faculty
     * @return \stdClass
     */
    private function facultyDataBuilder($faculty)
    {
        $result = new \stdClass();
        $result->FacultyId = $faculty->Id;
        $result->label = $result->value = $result->Name = $faculty->Name;
        return $result;
    }
}