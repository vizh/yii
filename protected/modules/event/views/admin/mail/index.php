<div class="btn-toolbar">
  <a href="<?=$this->createUrl('/event/admin/edit/index', ['eventId' => $event->Id]);?>" class="btn">&larr; <?=\Yii::t('app','Вернуться к редактору мероприятия');?></a>
  <a href="<?=$this->createUrl('/event/admin/mail/edit', ['eventId' => $event->Id]);?>" class="btn btn-success"><?=\Yii::t('app', 'Создать письмо');?></a>
</div>
<div class="well">
<?if (!empty($mails)):?>
<table class="table">
  <thead>
    <th><?=\Yii::t('app', 'Тема');?></th>
    <th><?=\Yii::t('app', 'Роли');?></th>
    <th><?=\Yii::t('app', 'Исключая роли');?></th>
    <th></th>
  </thead>
  <tbody>
    <?foreach ($mails as $mail):?>
      <tr>
        <td><?=$mail->Subject;?></td>
        <td>
          <?if (!empty($mail->Roles)):?>
            <?foreach ($mail->getRoles() as $role):?>
              <span class="label"><?=$role->Title;?></span>
            <?endforeach;?>
          <?else:?>
            <span class="label"><?=\Yii::t('app', 'Все');?></span>
          <?endif;?>
        </td>
        <td>
          <?if (!empty($mail->RolesExcept)):?>
            <?foreach ($mail->getRolesExcept() as $role):?>
              <span class="label m-bottom_5"><?=$role->Title;?></span>
            <?endforeach;?>
          <?else:?>
            <span class="label"><?=\Yii::t('app', 'Без исключений');?></span>
          <?endif;?>
        </td>
        <td><a href="<?=$this->createUrl('/event/admin/mail/edit', ['eventId' => $event->Id, 'id' => $mail->Id]);?>" class="btn"><?=\Yii::t('app', 'Редактировать');?></a></td>
      </tr>
    <?endforeach;?>
  </tbody>
</table>
<?else:?>
  <div class="alert alert-error"><?=\Yii::t('app', 'У мероприятия нет регистрационных писем!');?></div>
<?endif;?>
</div>