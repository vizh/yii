<?php
/**
 * @var User $user
 * @var Event $event
 * @var $this \partner\components\Controller
 */

use user\models\User;
use event\models\Event;

$data = $event->getUserData($user);
?>
<?php if (!empty($data)):?>
    <table class="table m-top_30 table-bordered table-striped user-data">
        <thead>
        <tr>
            <?php foreach($data[0]->getManager()->getDefinitions() as $definition):?>
                <th><?=$definition->title;?></th>
            <?php endforeach;?>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data as $row):?>
            <tr data-id="<?=$row->Id;?>">
                <?php foreach ($row->getManager()->getDefinitions() as $definition):?>
                    <td>
                        <div class="input hide">
                            <?=$definition->activeEdit($row->getManager(), ['class' => 'form-control', 'data-name' => $definition->name]);?>
                        </div>
                        <div class="value" data-name="<?=$definition->name;?>">
                            <?=$definition->getPrintValue($row->getManager());?>
                        </div>
                    </td>
                <?php endforeach;?>
                <td>
                    <div class="btn-group btn-group-xs">
                        <a href="#" class="btn btn-mini edit"><?=\Yii::t('app', 'Редактировать');?></a>
                        <a href="#" class="btn btn-mini btn-danger delete"><?=\Yii::t('app', 'Удалить');?></a>
                    </div>
                    <a href="#" class="btn btn-mini btn-success save hide"><?=\Yii::t('app', 'Сохранить');?></a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php endif;?>