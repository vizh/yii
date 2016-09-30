<div class="container m-top_40 m-bottom_40">
  <div class="row">
    <div class="span8 offset2">
      <div class="well">
        <h4 class="m-bottom_10"><?=Yii::t('app', 'Активация прилашения')?></h4>
        <?if(\Yii::app()->getUser()->getIsGuest()):?>
          <p><?=\Yii::t('app', 'Чтобы активировать приглашение на')?> <strong>&laquo;<?=$event->Title?>&raquo;</strong> <?=\Yii::t('app', 'со статусом')?> <strong>&laquo;<?=$invite->Role->Title?>&raquo;</strong> <?=\Yii::t('app', '<a id="PromoLogin" href="">авторизуйтесь или зарегистрируйтесь.</a>')?></p>
        <?elseif ($invite->UserId == null):?>
          <div class="alert alert-success m-top_20"><?=\Yii::t('app', 'Вы успешно активировавали приглашение на')?> <strong>&laquo;<?=$event->Title?>&raquo;</strong> <?=\Yii::t('app', 'со статусом')?> <strong>&laquo;<?=$invite->Role->Title?>&raquo;</strong></div>
          <a href="<?=$event->getUrl()?>"><?=\Yii::t('app', 'Перейти на страницу мероприятия')?></a>
        <?else:?>
          <div class="alert alert-error m-top_20"><?=\Yii::t('app', 'Ваше приглашение уже было успешно активировано ранее.')?></div>
          <a href="<?=$event->getUrl()?>"><?=\Yii::t('app', 'Перейти на страницу мероприятия')?></a>
        <?endif?>
      </div>
    </div>
  </div>
</div>