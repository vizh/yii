<?php
/**
 * @var \competence\models\Question[] $questions
 * @var \competence\models\Test $test
 * @var bool $hasErrors
 */
?>

<div class="container interview m-top_30 m-bottom_40">
    <div class="row m-top_30">
        <div class="span9 offset2">
            <?=CHtml::beginForm();?>

            <?if ($hasErrors):?>
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    Вы не ответили на один или несколько вопросов. Заполните вопросы, отмеченные сообщением об ошибке, и отправьте данные анкеты повторно.
                </div>
            <?endif;?>

            <?foreach($questions as $question):?>
                <h3>
                    <?=$question->Title;?>
                    <?if (!empty($question->SubTitle)):?>
                        <br><span><?=$question->SubTitle;?></span>
                    <?endif;?>
                </h3>
                <?
                $this->widget('competence\components\ErrorsWidget', array('form' => $question->getForm()));
                $this->renderPartial($question->getForm()->getViewPath(), ['form' => $question->getForm()]);
                ?>
            <?endforeach;?>

            <div class="row interview-controls">
                <div class="span8 text-center">
                    <input type="submit" class="btn btn-success" value="<?=$test->StartButtonText;?>" name="next">
                </div>
            </div>
            <?=CHtml::endForm();?>
        </div>
    </div>

</div>




