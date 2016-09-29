<?php
/**
 * @var \competence\models\test\appday14\Q5 $form
 */
?>


<script type="text/javascript">
    $(function () {
        $('input[type="radio"][data-group="Q5"]').change(function (event) {
            var target = $(event.currentTarget);
            var platforms = $('#Q5_platforms');
            if (target.val() == "q5_1") {
                platforms.css('display', 'block');
                platforms.find('input[type="radio"]').attr('disabled', null);
                platforms.find('input[type="radio"][data-group]:checked').trigger('change');
            } else {
                platforms.find('input').attr('disabled', 'disabled');
                platforms.css('display', 'none');
            }
        });
    });
</script>

<ul class="unstyled">
    <?foreach($form->getValues() as $value):?>
        <li>
            <label class="radio">
                <?=CHtml::activeRadioButton($form, 'value', ['value' => $value->key, 'uncheckValue' => null, 'data-group' => $form->getQuestion()->Code, 'data-target' => '#'.$form->getQuestion()->Code.'_'.$value->key])?>
                <?=$value->title?>
            </label>
            <?if($value->key == 'q5_1'):?>
                <div id="Q5_platforms" class="row" style="display: none;">
                    <div style="margin-left: 40px;margin-top: 10px;">
                        <ul class="unstyled">
                            <?foreach($form->getPlatforms() as $pvalue):?>
                                <li style="margin-bottom: 0px;">
                                    <label class="radio">
                                        <?=CHtml::activeRadioButton($form, 'platform', ['value' => $pvalue->key, 'uncheckValue' => null, 'data-group' => $form->getQuestion()->Code.'_pl', 'data-target' => '#'.$form->getQuestion()->Code.'_'.$pvalue->key])?>
                                        <?=$pvalue->title?>
                                    </label>
                                </li>
                            <?endforeach?>
                        </ul>
                    </div>
                </div>
            <?endif?>
            <?if($value->isOther):?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($form, 'other', ['class' => 'span4', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code.'_'.$value->key])?>
            <?endif?>
        </li>
    <?endforeach?>
</ul>