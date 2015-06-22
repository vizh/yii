<?php
/**
 * @var $this\partner\components\Controller
 * @var \partner\models\forms\program\Hall[] $forms
 * @var CActiveForm $activeForm
 */

use application\helpers\Flash;
use event\models\section\LinkHall;

$this->setPageTitle(\Yii::t('app', 'Список залов'));
?>

<?php $activeForm = $this->beginWidget('CActiveForm');?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-th"></span> <?=\Yii::t('app', 'Список залов');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=Flash::html();?>
        <ul class="nav nav-tabs nav-tabs-simple m-bottom_20">
            <?php foreach (\Yii::app()->params['Languages'] as $lang):?>
                <li <?php if (isset($forms[0]) && $lang === $forms[0]->getLocale()):?>class="active"<?php endif;?>>
                    <?=\CHtml::link($lang, ['hall', 'locale' => $lang]);?>
                </li>
            <?php endforeach;?>
        </ul>

        <div class="table-info">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?=\Yii::t('app', 'Название');?></th>
                        <th><?=\Yii::t('app', 'Сортировка');?></th>
                        <th><?=\Yii::t('app', 'Удалить');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($forms as $form):?>
                        <?php if ($form->hasErrors()):?>
                            <tr>
                                <td colspan="3">
                                    <?=$activeForm->errorSummary($form, '<div class="alert alert-danger" style="margin: 0;">', '</div>');?>
                                </td>
                            </tr>
                        <?php endif;?>
                        <tr>
                            <td><?=$activeForm->textField($form, 'Title[' . $form->getActiveRecord()->Id . ']', ['class' => 'form-control', 'value' => $form->Title]);?></td>
                            <td><?=$activeForm->textField($form, 'Order[' . $form->getActiveRecord()->Id . ']', ['class' => 'form-control', 'value' => $form->Order]);?></td>
                            <td><?=$activeForm->checkBox($form, 'Delete[' . $form->getActiveRecord()->Id . ']', ['checked' => $form->Delete == 1, 'disabled' => LinkHall::model()->byHallId($form->getActiveRecord()->Id)->exists()]);?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']);?>
    </div>
</div>
<?php $this->endWidget();?>