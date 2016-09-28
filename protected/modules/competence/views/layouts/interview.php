<?php
/**
 * @var MainController $this
 */

$form = $this->question->getForm();

?>
<?$this->beginContent('/layouts/public')?>
    <div class="row">
        <div class="span9 offset2">
            <?=CHtml::beginForm()?>
            <input type="hidden" name="question" value="<?=$this->question->Id?>">
            <?=CHtml::activeHiddenField($form, '_t')?>

            <?=$this->question->BeforeTitleText != null ? $this->question->BeforeTitleText : ''?>

            <h3>
                <?=$form->getTitle()?>
                <?if(!empty($this->question->SubTitle)):?>
                    <br><span><?=$this->question->SubTitle?></span>
                <?endif?>
            </h3>

            <?$this->widget('competence\components\ErrorsWidget', ['form' => $form])?>

            <?=$this->question->AfterTitleText != null ? $this->question->AfterTitleText : ''?>

            <?=$content?>

            <?=$this->question->AfterQuestionText != null ? $this->question->AfterQuestionText : ''?>


            <div class="row-fluid interview-controls">
                <div class="span8 text-center">
                    <?if($form->getPrev() !== null):?>
                        <input type="submit" class="btn" style="margin-right: 30px;" value="Вернуться" name="prev">
                    <?endif?>
                    <input type="submit" class="btn btn-success" value="<?=$form->getBtnNextLabel()?>" name="next">
                </div>
            </div>

            <?=CHtml::endForm()?>
        </div>
    </div>
<?$this->endContent()?>