<?/**
 * @var \user\models\User $user
 */
?>
<?$editUrl = $this->createUrl('/user/admin/edit/index', ['runetId' => $user->RunetId, 'backUrl' => \Yii::app()->getRequest()->getRequestUri()]);?>
<td style="width: 1px;font-weight: bold;"><?=$user->RunetId;?></td>
<td style="width: 50px;">
  <a href="<?=$editUrl;?>"><img src="<?=$user->getPhoto()->get50px();?>" /></a>
</td>
<td><a href="<?=$editUrl;?>"><?=$user->getFullName();?></a><br/><?=$user->Email;?></td>
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
<td style="text-align: right;"><a href="<?=$editUrl;?>" class="btn"><?=\Yii::t('app', 'Редактировать');?></a></td>