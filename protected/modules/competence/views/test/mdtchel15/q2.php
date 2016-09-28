<?php
/**
 * @var \competence\models\test\mdtchel15\Q2 $form
 */
?>

<script type="text/javascript">
    $(function () {
        $('input[id*="\Q2_value"]').change(function (e) {
            var $target = $(e.currentTarget);
            if ($target.val() == 'q2_2') {
                $('#Q2_values').show();
            } else {
                $('#Q2_values').hide();
                $('#Q2_values').find('input[type="radio"]').removeAttr('checked');
            }
        }).filter(':checked').trigger('change');
    });
</script>
<ul class="unstyled">
    <?foreach($form->getValues() as $value):?>
        <li>
            <label class="radio">
                <?=CHtml::activeRadioButton($form, 'value', ['value' => $value->key, 'uncheckValue' => null])?>
                <?=$value->title?>
                <?if($value->key == 'q2_2'):?>
                    <div id="Q2_values" class="row" style="display: none;">
                        <div class="span8 m-top_10">
                            <ul class="unstyled">
                                <?foreach($form->getQ2Values() as $value):?>
                                    <li>
                                        <label class="radio">
                                            <?=CHtml::activeRadioButton($form, 'q2_value', ['value' => $value->key, 'uncheckValue' => null])?>
                                            <?=$value->title?>
                                        </label>
                                    </li>
                                <?endforeach?>
                            </ul>
                        </div>
                    </div>
                <?endif?>
            </label>
        </li>
    <?endforeach?>
</ul>
