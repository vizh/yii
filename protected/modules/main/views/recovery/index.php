<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Восстановление пароля')?></span>
    </div>
  </div>
</h2>
<div class="container">
  <div class="row">
    <div class="span12">
      <?if(\Yii::app()->user->hasFlash('error')):?>
      <div class="alert alert-error">
        <?=\Yii::app()->user->getFlash('error')?>
      </div>
      <?endif?>
    </div>
  </div>
</div>