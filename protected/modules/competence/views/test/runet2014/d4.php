<?/**
 *  @var D4 $form
 */
use competence\models\test\runet2014\D4;

?>

<table class="table table-striped">
    <?foreach ($form->getInitiatives() as $qKey => $initiative):?>
        <tr>
            <td><strong><?=$initiative[0];?></strong></td>
            <td><?=$initiative[1];?></td>
            <td>
                <?
                $attrs = [];
                ?>
                <?=\CHtml::activeDropDownList($form, 'value['.$qKey.']', ['-',1,2,3,4,5,6,7], $attrs);?>
            </td>
        </tr>
    <?endforeach;?>
</table>