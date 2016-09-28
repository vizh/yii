<?php
/**
 * @var \competence\models\Test[] $tests
 */
?>

<div class="btn-toolbar clearfix">
    <a class="btn btn-success" href="<?=Yii::app()->createUrl('/competence/admin/main/editTest')?>"><i class="fa fa-plus"></i> Создать тест</a>
</div>

<div class="well">
    <table class="table">
        <thead>
        <tr>
            <th><?=\Yii::t('app', 'ID')?></th>
            <th><?=\Yii::t('app', 'Код')?></th>
            <th>Название теста</th>
            <th></th>
        </tr>
        </thead>
        <?foreach($tests as $test):?>
            <tr>
                <td><?=$test->Id?></td>
                <td><?=$test->Code?></td>
                <td><?=$test->Title?></td>
                <td style="white-space: nowrap;">
                    <a href="<?=$this->createUrl('/competence/admin/main/editTest',
                        ['id' => $test->Id])?>" class="btn"><i class="icon-edit"></i>&nbsp;<?=\Yii::t('app',
                            'Редактировать Тест')?></a>
                    <a href="<?=$this->createUrl('/competence/admin/main/edit',
                        ['id' => $test->Id])?>" class="btn"><i class="icon-edit"></i>&nbsp;<?=\Yii::t('app',
                            'Редактировать Вопросы')?></a>
                    <a href="<?=$this->createUrl('/competence/admin/export/index',
                        ['id' => $test->Id])?>" class="btn"><i class="icon-info-sign"></i>&nbsp;<?=\Yii::t('app',
                            'Статистика')?></a>
                </td>
            </tr>
        <?endforeach?>
    </table>
</div>
