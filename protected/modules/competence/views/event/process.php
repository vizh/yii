<?php
/**
 * @var application\components\controllers\PublicMainController $this
 * @var Event $event
 * @var User $user
 * @var Test $test
 * @var Question[] $questions
 */

use event\models\Event;
use user\models\User;
use competence\models\Test;
use competence\models\Question;
?>
<div class="container interview m-top_30 m-bottom_40">
    <div class="row m-top_30">
        <div class="span9 offset2">
            <?=CHtml::beginForm()?>
            <?php if ($hasErrors): ?>
                <div class="alert alert-error">
                    Вы не ответили на один или несколько вопросов. Заполните вопросы, отмеченные сообщением об ошибке, и отправьте данные анкеты повторно.
                </div>
            <?php endif ?>

            <?php foreach($questions as $question): ?>
                <div class="question" data-required="<?=intval($question->Required)?>">
                    <h3 class="m-top_40">
                        <?=CHtml::encode($question->Title)?>
                        <?php if (!empty($question->SubTitle)): ?>
                            <br><span><?=$question->SubTitle?></span>
                        <?php endif ?>
                    </h3>
                    <?php
                        $this->widget('competence\components\ErrorsWidget', ['form' => $question->getForm()]);
                        $this->renderPartial($question->getForm()->getViewPath(), ['form' => $question->getForm()]);
                    ?>
                    <?php if (!empty($question->AfterQuestionText)): ?>
                        <?=$question->AfterQuestionText;?>
                    <?php endif ?>

                    <hr>
                </div>
            <?endforeach;?>
            <div class="row interview-controls">
                <div class="span8 text-center">
                    <input type="submit" class="btn btn-success" value="<?=Yii::t('app', 'Отправить анкету')?>" name="next">
                </div>
            </div>
            <?=CHtml::endForm()?>
        </div>
    </div>
</div>

<div class="interview-progress">
    <div class="progress progress-striped active">
        <div class="bar" style="width: 0;">
            <span></span>
        </div>
    </div>
</div>

