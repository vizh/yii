<?php
/**
 * @var \event\widgets\Competence $this
 * @var \competence\models\Test $test
 */
$question = $test->getFirstQuestion();
?>
<div class="registration" style="padding-left: 0; padding-right: 0;">
    <h3 class="text-center competence-title"><?=$test->Title?></h3>
    <div class="row">
        <div class="span9 offset2">
            <?=CHtml::beginForm()?>
                <?=CHtml::hiddenField('CompetenceTest', $test->Id)?>
                <?foreach($this->questions as $question):?>
                    <h3 style="margin-bottom: 10px; margin-top: 20px;">
                        <?=$question->Title?>
                        <?if(!empty($question->SubTitle)):?>
                            <br><span><?=$question->SubTitle?></span>
                        <?endif?>
                    </h3>
                    <?
                    $this->widget('competence\components\ErrorsWidget', array('form' => $question->getForm()));
                    $this->render($question->getForm()->getViewPath(), ['form' => $question->getForm()]);
                   ?>
                <?endforeach?>
                <div class="row interview-controls">
                    <div class="span8 text-center">
                        <input type="submit" class="btn btn-success" value="<?=$test->StartButtonText?>" name="next">
                    </div>
                </div>
            <?=CHtml::endForm()?>
        </div>
    </div>
</div>