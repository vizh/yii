<div class="btn-toolbar"></div>
<div class="well">
  <?if (\Yii::app()->getUser()->hasFlash('success')):?>
    <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
  <?endif;?>
    
  <?if (!empty($formProducts)):?>
  <table class="table m-bottom_40">
    <thead>
      <th><?=\Yii::t('app', 'Название товара');?></th>
      <th><?=\Yii::t('app', 'Менеджер');?></th>
      <th></th>
    </thead>
    <tbody>
      <?foreach ($formProducts as $formProduct):?>
        <tr>
          <td><?=$formProduct->getProduct()->Title;?></td>
          <td><?=$formProduct->getManagerTitle();?></td>
          <td class="text-right"><a href="#" class="btn btn-mini"><?=\Yii::t('app', 'Редактировать');?></a></td>
        </tr>
        <tr class="form">
          <td colspan="3">
            <?
            $prices = [];
            foreach ($formProduct->Prices as $price)
            {
              $prices[] = $price->getAttributes();
            }
            ?>
            <?=\CHtml::form('','POST',['class' => 'form-horizontal', 'data-prices' => json_encode($prices), 'data-price-iterator' => 0]);?>
            <?=\CHtml::errorSummary($formProduct, '<div class="alert alert-error">', '</div>');?>
            <div class="control-group">
              <?=\CHtml::activeLabel($formProduct, 'Title', ['class' => 'control-label']);?>
              <div class="controls">
                <?=\CHtml::activeTextField($formProduct, 'Title', ['class' => 'input-xxlarge']);?>
              </div>
            </div>
            <div class="control-group">
              <?=\CHtml::activeLabel($formProduct, 'EnableCoupon', ['class' => 'control-label']);?>
              <div class="controls">
                <?=\CHtml::activeCheckBox($formProduct, 'EnableCoupon');?>
              </div>
            </div>
            <div class="control-group">
              <?=\CHtml::activeLabel($formProduct, 'Public', ['class' => 'control-label']);?>
              <div class="controls">
                <?=\CHtml::activeCheckBox($formProduct, 'Public');?>
              </div>
            </div>
            <div class="control-group">
              <?=\CHtml::activeLabel($formProduct, 'Priority', ['class' => 'control-label']);?>
              <div class="controls">
                <?=\CHtml::activeDropDownList($formProduct, 'Priority', $formProduct->getPriorityData());?>
              </div>
            </div>
            <div class="control-group">
              <?=\CHtml::activeLabel($formProduct, 'Unit', ['class' => 'control-label']);?>
              <div class="controls">
                <?=\CHtml::activeTextField($formProduct, 'Unit');?>
              </div>
            </div>
            
            <?$productAttributeNames = $formProduct->getProduct()->getManager()->getProductAttributeNames();?>
            <?if (!empty($productAttributeNames)):?>
              <div class="control-group" style="margin-bottom: 0;">
                <div class="controls">
                  <h5><?=$formProduct->getAttributeLabel('Attributes');?></h5>
                </div>
              </div>
              <?foreach ($productAttributeNames as $name):?>
                <div class="control-group">
                  <label class="control-label"><?=$name;?></label>
                  <div class="controls">
                    <?=\CHtml::activeTextField($formProduct, 'Attributes['.$name.']', ['value' => isset($formProduct->Attributes[$name]) ? $formProduct->Attributes[$name] : '']);?>
                  </div>
                </div>
              <?endforeach;?>
            <?endif;?>
            
            <div class="control-group" style="margin-bottom: 0;">
              <div class="controls">
                <h5><?=$formProduct->getAttributeLabel('Prices');?></h5> <?=\CHtml::link(\Yii::t('app', 'Добавить цену'), '#', ['class' => 'btn btn-mini m-bottom_10 new-price']);?>
              </div>
            </div>
            <div class="prices"></div>
            
            <div class="control-group">
              <div class="controls">
                <?=\CHtml::activeHiddenField($formProduct, 'Id');?>
                <?=\CHtml::activeHiddenField($formProduct, 'ManagerName');?>
                <button type="submit" value="" class="btn btn-info"><?=\Yii::t('app', 'Сохранить');?></button>
                <button type="submit" value="1" name="<?=\CHtml::activeName($formProduct, 'Delete');?>" class="btn btn-danger"><?=\Yii::t('app', 'Удалить');?></button>
              </div>
            </div>
            <?=\CHtml::endForm();?>
          </td>
        </tr>
      <?endforeach;?>
    </tbody>
  </table>
  <?endif;?>
  
  <div class="row-fluid">
    <div class="span12">
      <?=\CHtml::form('','POST',['class' => 'form-horizontal well']);?>
        <h3 class="controls"><?=\Yii::t('app', 'Новый товар');?></h3>
        <?=\CHtml::errorSummary($formNewProduct, '<div class="alert alert-error">', '</div>');?>
        <div class="control-group">
          <?=\CHtml::activeLabel($formNewProduct, 'Title', ['class' => 'control-label']);?>
          <div class="controls">
            <?=\CHtml::activeTextField($formNewProduct, 'Title', ['class' => 'input-xxlarge']);?>
          </div>
        </div>
        <div class="control-group">
          <?=\CHtml::activeLabel($formNewProduct, 'Unit', ['class' => 'control-label']);?>
          <div class="controls">
            <?=\CHtml::activeTextField($formNewProduct, 'Unit');?>
          </div>
        </div>
        <div class="control-group">
          <?=\CHtml::activeLabel($formNewProduct, 'ManagerName', ['class' => 'control-label']);?>
          <div class="controls">
            <?=\CHtml::activeDropDownList($formNewProduct, 'ManagerName', $formNewProduct->getManagerData());?>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button type="submit" value="" class="btn btn-info"><?=\Yii::t('app', 'Добавить новый новар');?></button>
          </div>
        </div>
      <?=\CHtml::endForm();?>
    </div>
  </div>
  
  <div id="tpl__price-control-group" style="display: none;">
    <div class="controls">
      <input type="text" value="<%=Price%>" class="input-mini" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][Price]');?>" />
      <input type="text" value="<%=StartDate%>" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][StartDate]');?>" /> &mdash;
      <input type="text" value="<%=EndDate%>" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][EndDate]');?>');?>" /> 
      <a href="#" class="btn btn-danger"><?=\Yii::t('app', 'Удалить');?></a>
      <input type="hidden" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][ProductId]');?>" value="<%=ProductId%>" />
      <input type="hidden" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][Id]');?>" value="<%=Id%>" />
      <input type="hidden" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][Delete]');?>" value="" />
    </div>
  </div>
</div>