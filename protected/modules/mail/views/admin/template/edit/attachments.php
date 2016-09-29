<?php
/**
 * @var \application\components\controllers\AdminMainController $this
 * @var Template $form
 * @var \application\widgets\ActiveForm $activeForm
 */

use \mail\models\forms\admin\Template;
?>

<div id="attach">
    <div class="control-group">
        <?=$activeForm->label($form, 'Attachments', ['class' => 'control-label'])?>
        <div class="controls">
            <?$this->widget('CMultiFileUpload', [
                'model' => $form,
                'attribute' => 'Attachments',
                'htmlOptions' => ['class' => 'form-control', 'id' => 'Attachments']
            ])?>
            <?if($form->isUpdateMode() && file_exists($form->getPathAttachments())):?>
                <?$files = CFileHelper::findFiles($form->getPathAttachments())?>
                <table class="table table-striped table-bordered m-top_30">
                    <?php foreach($files as $file):?>
                        <?$name = basename($file)?>
                        <tr>
                            <td><?=\CHtml::link($name)?></td>
                            <td style="width: 1px;">
                                <?=\CHtml::link('<i class="icon-remove"></i>', ['deleteattachment', 'id' => $form->getActiveRecord()->Id, 'file' => $name], ['class' => 'btn btn-mini'])?>
                            </td>
                        </tr>
                    <?endforeach?>
                </table>
            <?endif?>
        </div>
    </div>
</div>
