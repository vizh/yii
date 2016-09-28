<?php
/**
 * @var \competence\models\test\devcon15\Q12 $form
 */
?>

<script type="text/javascript">
    $(function () {
        $('input[id*="\Q12_value"]').change(function (e) {
            var $target = $(e.currentTarget);
            if ($target.val() == 'q12_2') {
                $('#Q12_values').show();
            } else {
                $('#Q12_values').hide();
                $('#Q12_values').find('input[type="radio"]').removeAttr('checked');
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
                <?if($value->key == 'q12_2'):?>
                    <div id="Q12_values" class="row" style="display: none;">
                        <div class="span8 m-top_10">
                            <ul class="unstyled">
                                <?foreach($form->getQ12Values() as $value):?>
                                    <li>
                                        <label class="radio">
                                            <?=CHtml::activeRadioButton($form, 'q12_value', ['value' => $value->key, 'uncheckValue' => null])?>
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
