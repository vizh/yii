<?/**
 *  @var D5 $form
 */
use competence\models\test\runet2014\D5;

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
                <?=\CHtml::activeDropDownList($form, 'value['.$qKey.']', ['-',-3,-2,-1,0,1,2,3], $attrs);?>
            </td>
        </tr>
    <?endforeach;?>
</table>