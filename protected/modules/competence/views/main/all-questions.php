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

        <?= CHtml::beginForm() ?>
        <?php if ($hasErrors): ?>
            <div class="alert alert-error">
                <?= Yii::t('app', 'Вы не ответили на один или несколько вопросов. Заполните вопросы, отмеченные сообщением об ошибке, и отправьте данные анкеты повторно.') ?>
            </div>
        <?php endif ?>

        <?php foreach ($questions as $question): ?>
            <div class="question" data-required="<?= intval($question->Required) ?>">
                <h3>
                    <?= CHtml::encode($question->Title) ?>
                    <?php if (!empty($question->SubTitle)): ?>
                        <br><span><?= $question->SubTitle ?></span>
                    <?php endif ?>
                </h3>

                <?php $this->widget('competence\components\ErrorsWidget', [
                    'form' => $question->getForm()
                ]) ?>

                <?php $this->renderPartial($question->getForm()->getViewPath(), [
                    'form' => $question->getForm()
                ]) ?>

                <?php if (!empty($question->AfterQuestionText)): ?>
                    <?= $question->AfterQuestionText ?>
                <?php endif ?>

                <hr>
            </div>
        <?php endforeach ?>
        <div class="row interview-controls">
            <div class="span12 text-center">
                <input type="submit" class="btn btn-success" value="<?= Yii::t('app', 'Отправить анкету') ?>" name="next">
            </div>
        </div>
        <?= CHtml::endForm() ?>
    </div>
</div>

<?php if ($test->Id == 48 /* svyaz16 */): ?>
    <div class="alert alert-info">
        В случае возникновения вопросов при регистрации, пожалуйста, свяжитесь со службой технической поддержки:
        Тел.: +7 (495) 950-56-51 (с 9:00 до 18:00 по Московскому времени). E-mail: <?=CHtml::mailto('support@runet-id.com')?>
    </div>
<?php endif ?>

<?php if ($test->Id == 49 /* svyaz16_en */): ?>
    <div class="alert alert-info">
        In case you have any questions about online registration please contact technical support
        Tel.: +7 (495) 950-56-51 (from 9.00 am to 6.00 pm Moscow time).
        E-mail: <?=CHtml::mailto('support@runet-id.com')?>
    </div>
<?php endif ?>
