<?/**
 * @var \user\models\User $user
 */
$editUrl = ['admin/edit/index', 'runetId' => $user->RunetId, 'backUrl' => \Yii::app()->getRequest()->getRequestUri()];
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
<td>
    <?if ($user->Visible):?>
        <span class="label label-success"><?=\Yii::t('app', 'Активный аккаунт');?></span>
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