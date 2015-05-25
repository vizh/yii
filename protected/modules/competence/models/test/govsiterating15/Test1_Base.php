<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 14.05.2015
 * Time: 12:09
 */

namespace competence\models\test\govsiterating15;


use competence\models\form\Single;
use competence\models\Result;

class Test1_Base extends Single
{
    /**
     * @return array
     */
    public function getInternalExportValueTitles()
    {
        $titles[] = 'Значение';
        return $titles;
    }

    /**
     * @param Result $result
     * @return array
     */
    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $value = !empty($questionData) ? $questionData['value'] : '-';
        return [$value];
    }
} 