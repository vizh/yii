<?php
/**
 * @var MainController $this
 */

$form = $this->question->getForm();

?>
<?php $this->beginContent('/layouts/public') ?>
    <div class="row m-top_30">
        <div class="span9 offset2">
            <?= CHtml::beginForm(); ?>
            <input type="hidden" name="question" value="<?=$this->question->Id?>">
            <?= CHtml::activeHiddenField($form, '_t') ?>

            <?= $this->question->BeforeTitleText != null ? $this->question->BeforeTitleText : '' ?>

            <h3>
                <?= $form->getTitle(); ?>
                <?php if (!empty($this->question->SubTitle)): ?>
                    <br><span><?= $this->question->SubTitle ?></span>
                <?php endif ?>
            </h3>

            <?php $this->widget('competence\components\ErrorsWidget', ['form' => $form]) ?>

            <?= $this->question->AfterTitleText != null ? $this->question->AfterTitleText : '' ?>

            <?= $content ?>

            <?= $this->question->AfterQuestionText != null ? $this->question->AfterQuestionText : '' ?>


            <div class="row interview-controls">
                <div class="span8 text-center">
                    <?php if ($form->getPrev() !== null): ?>
                        <input type="submit" class="btn" style="margin-right: 30px;" value="Вернуться" name="prev">
                    <?php endif ?>
                    <input type="submit" class="btn btn-success" value="<?=$form->getBtnNextLabel()?>" name="next">
                </div>
            </div>

            <?= CHtml::endForm() ?>
        </div>
    </div>
<?php $this->endContent() ?>