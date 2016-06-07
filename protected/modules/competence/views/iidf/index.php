<?php
/**
 * @var MainController $this
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
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?= CHtml::beginForm('', 'POST', ['class' => 'form-horizontal']) ?>
            <?php foreach ($questions as $question): ?>
                <div class="question">
                    <h3><?= Html::encode($question->Title) ?></h3>
                    <?php
                    $this->widget('competence\components\ErrorsWidget', ['form' => $question->getForm()]);
                    $this->renderPartial($question->getForm()->getViewPath(), ['form' => $question->getForm()]);
                    ?>
                    <?php if (!empty($question->AfterQuestionText)): ?>
                        <?= Html::encode($question->AfterQuestionText) ?>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <input type="submit" class="btn btn-lg btn-primary"
                           value="<?= Yii::t('app', 'Подписаться на новости') ?>" name="next">
                </div>
            </div>
            <?= CHtml::endForm() ?>
        </div>
    </div>
</div>

