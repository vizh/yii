<?php
namespace competence\models\test\runet2014;

use competence\models\form\Textarea;

class C3A extends Textarea
{
    use QuestionsByCode;

    public function getCodes()
    {
        return ['C1', 'C2', 'C3'];
    }


    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2014.comment';
    }
} 