<?
/**
 * @var \application\models\ProfessionalInterest[] $ecosystems
 */
?>
<div class="container">
  <div class="row">
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