<?php
/**
 * @var MainController $this
 * @var User $user
 * @var Test $test
 * @var Question[] $questions
 * @var array $hasErrors
 */

use user\models\User;
use competence\models\Test;
use competence\models\Question;

$this->pageTitle = $test->Title;
?>

<div class="row" style="padding: 30px;">
    <div class="span11">
        <div class="m-bottom_40">
            <?=$test->Info?>
        </div>

        <?=CHtml::beginForm()?>
        <?if($hasErrors):?>
            <div class="alert alert-error">
                <?=Yii::t('app', 'Вы не ответили на один или несколько вопросов. Заполните вопросы, отмеченные сообщением об ошибке, и отправьте данные анкеты повторно.')?>
            </div>
        <?endif?>

        <?foreach($questions as $question):?>
            <div class="question" data-required="<?=intval($question->Required)?>">
                <h3>
                    <?=CHtml::encode($question->Title)?>
                    <?if(!empty($question->SubTitle)):?>
                        <br><span><?=$question->SubTitle?></span>
                    <?endif?>
                </h3>

                <?$this->widget('competence\components\ErrorsWidget', [
                    'form' => $question->getForm()
                ])?>

                <?$this->renderPartial($question->getForm()->getViewPath(), [
                    'form' => $question->getForm()
                ])?>

                <?if(!empty($question->AfterQuestionText)):?>
                    <?=$question->AfterQuestionText?>
                <?endif?>

                <hr>
            </div>
        <?endforeach?>
        <div class="row interview-controls">
            <div class="span12 text-center">
                <input type="submit" class="btn btn-success" value="<?=Yii::t('app', 'Отправить анкету')?>" name="next">
            </div>
        </div>
        <?=CHtml::endForm()?>
    </div>
</div>
