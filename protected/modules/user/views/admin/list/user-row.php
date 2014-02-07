<?$editUrl = $this->createUrl('/user/admin/edit/index', ['runetId' => $user->RunetId, 'backUrl' => \Yii::app()->getRequest()->getRequestUri()]);?>
<td style="width: 1px;font-weight: bold;"><?=$user->RunetId;?></td>
<td><a href="<?=$editUrl;?>"><?=$user->getFullName();?></a><br/><?=$user->Email;?></td>
<td style="text-align: right;"><a href="<?=$editUrl;?>" class="btn"><?=\Yii::t('app', 'Редактировать');?></a></td>