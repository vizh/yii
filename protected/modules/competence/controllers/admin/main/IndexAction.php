<?php
namespace competence\controllers\admin\main;

class IndexAction extends \CAction
{
    public function run()
    {
        $tests = \competence\models\Test::model()->findAll(['order' => '"t"."Id" DESC']);

        $this->getController()->render('index', ['tests' => $tests]);
    }
}