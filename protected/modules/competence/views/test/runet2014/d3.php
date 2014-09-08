<?/**
 *  @var D3 $form
 */
use competence\models\test\runet2014\D3;

?>

<table class="table table-striped">
    <?foreach ($form->getInitiatives() as $qKey => $initiative):?>
        <tr>
            <td><strong><?=$initiative[0];?></strong></td>
            <td><?=$initiative[1];?></td>
            <td>
                <?
                $attrs = [
                    'class' => 'input-block-level'
                ];
                ?>
                <?=\CHtml::activeDropDownList($form, 'value['.$qKey.']', $form->getValues(), $attrs);?>
            </td>
        </tr>
    <?endforeach;?>
</table>