<?php
/**
 * @var \event\models\Event $event
 */
?>


<div class="btn-toolbar">
    <a href="<?=$this->createUrl('/event/admin/edit/index', ['eventId' => $event->Id])?>" class="btn">&larr; <?=\Yii::t('app','Вернуться к редактору мероприятия')?></a>

    <a class="btn btn-success" href="<?=Yii::app()->createUrl('/event/admin/edit/partedit', ['eventId' => $event->Id])?>">Создать новую часть</a>
</div>

<div class="well">
    <?if(\Yii::app()->getUser()->hasFlash('success')):?>
        <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success')?></div>
    <?endif?>

    <?if(count($event->Parts) > 0):?>
    <table class="table m-bottom_40">
        <thead>
        <tr>
            <th>ID</th>
            <th><?=\Yii::t('app', 'Название части')?></th>
            <th><?=\Yii::t('app', 'Сортировка')?></th>
            <th class="span2"></th>
        </tr>
        </thead>
        <tbody>
        <?foreach($event->Parts as $part):?>
            <tr>
                <td><?=$part->Id?></td>
                <td><?=$part->Title?></td>
                <td><?=$part->Order?></td>
                <td>
                    <div class="btn-group">
                        <a class="btn" href="<?=Yii::app()->createUrl('/event/admin/edit/partedit', ['eventId' => $event->Id, 'partId' => $part->Id])?>"><i class="icon-edit"></i></a>
                        <a class="btn btn-danger" href="<?=Yii::app()->createUrl('/event/admin/edit/partdelete', ['eventId' => $event->Id, 'partId' => $part->Id])?>"><i class="icon-remove icon-white"></i></a>
                    </div>
                </td>
            </tr>
        <?endforeach?>
        </tbody>
    </table>
    <?php else:?>
        <div class="alert alert-info">
            <strong>Внимание!</strong><br>
            Создание частей требуется только для некоторых мерприятий. Перед созданием частей мероприятия убедитесь, что это действительно необходимо.
        </div>
    <?endif?>
</div>