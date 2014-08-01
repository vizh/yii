<?
/**
 * @var \application\models\ProfessionalInterest[] $ecosystems
 */
?>
<h2 class="b-header_large light">
    <div class="line"></div>
    <div class="container">
        <div class="title">
            <span class="backing runet">RUNET</span>
            <span class="backing text"><?=\Yii::t('app', 'Экосистемы Рунета');?></span>
        </div>
    </div>
</h2>
<div class="container">
  <div class="row">
      <div class="span1">

      </div>
      <div class="span11">
          <div clas="row">
              <?foreach ($ecosystems as $ecosystem):?>
                  <div class="ecosystem span5">
                      <h2><?=$ecosystem->En;?></h2>
                      <p><?=$ecosystem->Title;?></p>
                      <?if (!empty($ecosystem->Description)):?>
                          <p class="muted"><?=$ecosystem->Description;?></p>
                      <?endif;?>
                  </div>
              <?endforeach;?>
          </div>
      </div>
  </div>
</div>