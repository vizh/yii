<?php
/**
 * @var competence\models\Test $test;
 * @var competence\models\Question $question
 */
?>

<h2><?=$test->Title?> / <?=$question->Code?></h2>

<?=CHtml::form('','POST', ['class' => 'form-horizontal'])?>

    <div class="btn-toolbar clearfix">
        <a class="btn" href="<?=Yii::app()->createUrl('/competence/admin/main/edit', ['id' => $question->TestId])?>"><i class="icon-arrow-left"></i> Список вопросов</a>
        <input type="submit" value="Сохранить изменения" name="yt0" class="btn btn-success pull-right">
    </div>

    <div class="well">
        <?=CHtml::errorSummary($question, '<div class="alert alert-error">', '</div>')?>

        <div class="control-group">
            <?=CHtml::activeLabel($question, 'Title', ['class' => 'control-label'])?>
            <div class="controls">
                <?=CHtml::activeTextField($question, 'Title', ['class' => 'span6'])?>
            </div>
        </div>

        <div class="control-group">
            <?=CHtml::activeLabel($question, 'SubTitle', ['class' => 'control-label'])?>
            <div class="controls">
                <?=CHtml::activeTextArea($question, 'SubTitle', ['rows' => 2, 'class' => 'span6'])?>
            </div>
        </div>

        <div class="control-group">
            <?=CHtml::activeLabel($question, 'BeforeTitleText', ['class' => 'control-label'])?>
            <div class="controls">
                <?=CHtml::activeTextField($question, 'BeforeTitleText', ['class' => 'span6'])?>
            </div>
        </div>

        <div class="control-group">
            <?=CHtml::activeLabel($question, 'AfterTitleText', ['class' => 'control-label'])?>
            <div class="controls">
                <?=CHtml::activeTextField($question, 'AfterTitleText', ['class' => 'span6'])?>
            </div>
        </div>

        <div class="control-group">
            <?=CHtml::activeLabel($question, 'AfterQuestionText', ['class' => 'control-label'])?>
            <div class="controls">
                <?=CHtml::activeTextField($question, 'AfterQuestionText', ['class' => 'span6'])?>
            </div>
        </div>

        <div class="control-group">
            <?=CHtml::activeLabel($question, 'Required', ['class' => 'control-label'])?>
            <div class="controls">
                <?=CHtml::activeCheckBox($question, 'Required')?>
            </div>
        </div>

        <?if($question->getForm()->getAdminView() != null):?>
            <?=$this->renderPartial($question->getForm()->getAdminView(), ['question' => $question])?>
        <?endif?>
    </div>

<?=CHtml::endForm()?>