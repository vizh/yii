<form id="search" action="<?=\Yii::app()->getController()->createUrl('/search/result/index');?>" role="search">
  <div class="container">
    <input type="text" name="term" id="live-search" class="form-element_text ui-autocomplete-input" placeholder="<?php echo \Yii::t('app', 'Поиск по людям, компаниям, новостям');?>">
    <input type="image" class="form-element_image pull-right" src="/images/search-type-image-dark.png" width="20" height="19">
  </div>
</form>