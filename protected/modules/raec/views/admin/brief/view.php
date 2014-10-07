<?
/**
 *  @var Brief $brief
 */
use raec\models\Brief;
?>

<div class="btn-toolbar"></div>
<div class="well">
    <table class="table table-bordered">
        <tbody>
        <?foreach($brief->getBriefData()->getDefinitions() as $definition):?>
            <tr>
                <td><?=$brief->getBriefData()->getAttributeLabel($definition->name);?></td>
                <td>
                    <?$value = $definition->getPrintValue($brief->getBriefData());?>
                    <?=!empty($value) ? $value : '<span class="text-error">Поле не заполнено</span>';?>
                </td>
            </tr>
        <?endforeach;?>
        </tbody>
    </table>
</div>