<form id="search" action="<?=\Yii::app()->getController()->createUrl('/search/result/index');?>" role="search">
  <div class="container">
    <?=CHtml::textField('term', $value, [
      'id' => 'live-search',
      'class' => 'form-element_text ui-autocomplete-input',
      'placeholder' => \Yii::t('app', 'Поиск по людям, компаниям, мероприятиям')
    ]);?>
    <input type="image" class="form-element_image pull-right" src="/images/search-type-image-dark.png" width="20" height="19">
  </div>
</form>