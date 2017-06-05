<?php
namespace competence\models\base;

abstract class Single extends \competence\models\Question
{
    protected function getDefinedViewPath()
    {
        return "competence.views.base.single";
    }

    public abstract function getValues();
}