<?php
/**
 * @var \competence\models\test\education15\Q1 $form
 */
?>
<script type="text/javascript">
    $(function () {
        var $university = $('input[name*="Q1[University]"]');
        $('input[name*="Q1[UniversityLabel]"]').autocomplete({
            source: function (request, response) {
                $.getJSON('/education/ajax/universities', {term : request.term}, function(data) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.label,
                            value: item.Name,
                            id: item.UniversityId
                        }
                    }));
                });
            },
            select : function (event, ui) {
                $university.val(ui.item.id);

            },
            search: function( event, ui ) {
                $university.val('');
            }
        });
    });
</script>

<div class="form-group">
    <?=\CHtml::activeLabel($form, 'UniversityLabel', ['class' => 'control-label'])?>
    <div class="controls">
        <?=\CHtml::activeTextField($form, 'UniversityLabel', ['class' => 'input-block-level'])?>
    </div>
</div>
<div class="form-group">
    <?=\CHtml::activeLabel($form, 'Speciality', ['class' => 'control-label'])?>
    <div class="controls">
        <?=\CHtml::activeTextField($form, 'Speciality', ['class' => 'input-block-level'])?>
    </div>
</div>
<?=\CHtml::activeHiddenField($form, 'University')?>