<?/**
 * @var \user\models\User $user
 */
$editUrl = ['admin/edit/index', 'id' => $user->RunetId, 'backUrl' => \Yii::app()->getRequest()->getRequestUri()];
?>
<td style="width: 1px;font-weight: bold;"><?=$user->RunetId;?></td>
<td style="width: 50px;">
    <?=\CHtml::link(\CHtml::image($user->getPhoto()->get50px()), $editUrl);?>
</td>
<td><?=\CHtml::link($user->getFullName(), $editUrl);?><br/><?=$user->Email;?></td>
<td>
    <?if ($user->getEmploymentPrimary() !== null):?>
        <?=$user->getEmploymentPrimary()->Company->Name;?>
    <?endif;?>
</td>
<td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $user->CreationTime);?></td>
<td class="text-center">
    <?if ($user->Visible):?>
        <span class="label label-success"><?=\Yii::t('app', 'Активный аккаунт');?></span><br/>
        <div style="font-size: 80%;">
            <?php if ($user->Verified):?>
                <span class="text-success"><?=\Yii::t('app', 'Подтвержден');?></span>
            <?else:?>
                <span class="muted"><?=\Yii::t('app', 'Не подтвержден');?></span>
            <?endif;?>
        </div>
    <?php elseif (!empty($user->MergeUserId)):?>
        <span class="label label-info"><?=\Yii::t('app', 'Обьединен в ') . $user->MergeUser->RunetId . ', ' . $user->MergeUser->getFullName();?></span>
    <?else:?>
        <span class="label label-warning"><?=\Yii::t('app', 'Cкрытый аккаунт');?></span>
    <?endif;?>
</td>
<td style="text-align: right;">
    <div class="btn-group">
        <?=\CHtml::link('<i class="icon icon-edit"></i>', $editUrl, ['class' => 'btn']);?>
        <?=\CHtml::link('Документы', ['admin/document/edit', 'id' => $user->RunetId, 'backUrl' => \Yii::app()->getRequest()->getRequestUri()], ['class' => 'btn']);?>
    </div>
</td>