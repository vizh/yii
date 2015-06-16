<?php
/**
 * @var \partner\components\Controller $this
 * @var \event\models\UserData[] $data
 * @var \user\models\User $user
 */
?>
<?php $this->beginWidget('\application\widgets\bootstrap\Modal', [
    'id' => 'definitions_' . $user->RunetId,
    'header' => \Yii::t('app', 'Дополнительные параметры'),
    'htmlOptions' => ['class' => 'modal-blur']
]);?>

<table class="table table-info table-bordered table-striped">
    <thead>
        <tr>
            <?php foreach ($data[0]->getManager()->getDefinitions() as $definition):?>
                <td><?=$definition->title;?></td>
            <?php endforeach;?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row):?>
            <tr>
                <?php foreach ($row->getManager()->getDefinitions() as $definition):?>
                    <td><?=$definition->getPrintValue($row->getManager());?></td>
                <?php endforeach;?>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?$this->endWidget();?>