<?/**
 * @var \pay\models\forms\LoyalityProgramDiscount $form
 * @var \pay\models\LoyaltyProgramDiscount $discounts
 */
?>
<h2 class="m-bottom_30"><?=\Yii::t('app', 'Программа лояльности');?></h2>
<table class="table table-striped">
  <thead>
    <tr>
      <th><?=\Yii::t('app', 'Скидка');?></th>
      <th><?=\Yii::t('app', 'Дата начала');?></th>
      <th><?=\Yii::t('app', 'Дата окончания');?></th>
      <th><?=\Yii::t('app', 'Товар');?></th>
      <th><?=\Yii::t('app', 'Статус');?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?if (!empty($discounts)):?>
      <?foreach ($discounts as $discount):?>
        <?/** @var \pay\models\LoyaltyProgramDiscount $discount */?>
        <tr>
          <td><?=$discount->Discount * 100;?></td>
          <td>
            <?if ($discount->StartTime !== null):?>
              <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $discount->StartTime);?>
            <?else:?>
              <?=\Yii::t('app', 'Не указано');?>
            <?endif;?>
          </td>
          <td>
            <?if ($discount->EndTime !== null):?>
              <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $discount->EndTime);?>
            <?else:?>
              <?=\Yii::t('app', 'Не указано');?>
            <?endif;?>
          </td>
          <td>
            <?=($discount->Product !== null ? $discount->Product->Title : \Yii::t('app','Все товары'));?>
          </td>
          <td>
            <?switch($discount->getStatus()) {
              case $discount::StatusActive: echo '<span class="label label-success">'.\Yii::t('app', 'Активна').'</label>';
                break;
              case $discount::StatusEnd: echo '<span class="label">'.\Yii::t('app', 'Прошла').'</label>';
                break;
              case $discount::StatusSoon: echo '<span class="label">'.\Yii::t('app', 'Ожидание').'</label>';
                break;
              }
            ?>
          </td>
          <td>
            <?switch($discount->getStatus()) {
              case $discount::StatusActive: echo '<a href="'.$this->createUrl('/partner/settings/loyalty', ['discountId' => $discount->Id, 'action' => 'delete']).'" title="'.\Yii::t('app', 'Остановить').'"><i class="icon-pause"></i></a>';
                break;
              case $discount::StatusSoon: echo '<a href="'.$this->createUrl('/partner/settings/loyalty', ['discountId' => $discount->Id, 'action' => 'delete']).'" title="'.\Yii::t('app', 'Удалить').'"><i class="icon-trash"></i></a>';
                break;
            }
            ?>
          </td>
        </tr>
      <?endforeach;?>
    <?else:?>
      <tr>
        <td colspan="6" style="text-align: center;"><?=\Yii::t('app', 'Скидок нет!');?></td>
      </tr>
    <?endif;?>
  </tbody>
  <tfoot>
  <tr style="background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAFUlEQVQImWNgQAOPHz/+T3UBBgYGAL+IEklz7bqmAAAAAElFTkSuQmCC);">
    <td colspan="6">
      <?=\CHtml::beginForm('','POST', ['class' => 'form-inline', 'style' => 'margin-bottom: 0;']);?>
        <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
        <?=\CHtml::activeTextField($form, 'Discount', ['class' => 'input-medium', 'placeholder' => $form->getAttributeLabel('Discount')]);?>
        <?=\CHtml::activeTextField($form, 'StartDate', ['class' => 'input-medium', 'placeholder' => $form->getAttributeLabel('StartDate')]);?>
        <?=\CHtml::activeTextField($form, 'EndDate', ['class' => 'input-medium', 'placeholder' => $form->getAttributeLabel('EndDate')]);?>
        <?=\CHtml::activeDropDownList($form, 'ProductId', $form->getProductData())?>
        <?=\CHtml::submitButton(\Yii::t('app','Сохранить'), ['class' => 'btn']);?>
      <?=\CHtml::endForm();?>
    </td>
    <?=\CHtml::endForm();?>
  </tr>
  </tfoot>
</table>