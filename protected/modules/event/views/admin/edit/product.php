<div class="btn-toolbar">
  <a href="<?=$this->createUrl('/event/admin/edit/index', ['eventId' => $event->Id]);?>" class="btn">&larr; <?=\Yii::t('app','Вернуться к редактору мероприятия');?></a>
</div>
<div class="well">
  <?if (\Yii::app()->getUser()->hasFlash('success')):?>
    <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
  <?endif;?>
    
  <?if (!empty($formProducts)):?>
  <table class="table m-bottom_40">
    <thead>
    <tr>
      <th>ID</th>
      <th><?=\Yii::t('app', 'Название товара');?></th>
      <th><?=\Yii::t('app', 'Менеджер');?></th>
      <th></th>
    </tr>
    </thead>
    <tbody>
      <?foreach ($formProducts as $formProduct):?>
        <tr>
          <td><?=$formProduct->getProduct()->Id;?></td>
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

            $additionalAttributes = [];
            foreach ($formProduct->AdditionalAttributes as $additionalAttribute)
            {
              $additionalAttributes[] = $additionalAttribute->getAttributes();
            }
            ?>
            <form method="POST" class="form-horizontal" data-prices='<?=json_encode($prices);?>' data-price-iterator ="0" data-additional-attributes='<?=json_encode($additionalAttributes);?>' data-additional-attribute-iterator="0">
            <?=\CHtml::errorSummary($formProduct, '<div class="alert alert-error">', '</div>');?>
            <div class="control-group">
              <?=\CHtml::activeLabel($formProduct, 'Title', ['class' => 'control-label']);?>
              <div class="controls">
                <?=\CHtml::activeTextField($formProduct, 'Title', ['class' => 'input-xxlarge']);?>
              </div>
            </div>
            <div class="control-group">
              <?=\CHtml::activeLabel($formProduct, 'Description', ['class' => 'control-label']);?>
              <div class="controls">
                <?=\CHtml::activeTextArea($formProduct, 'Description', ['class' => 'input-xxlarge', 'style' => 'height: 120px;']);?>
              </div>
            </div>
            <div class="control-group">
              <?=\CHtml::activeLabel($formProduct, 'OrderTitle', ['class' => 'control-label']);?>
              <div class="controls">
                <?=\CHtml::activeTextArea($formProduct, 'OrderTitle', ['class' => 'input-xxlarge', 'style' => 'height: 40px;']);?>
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
                    <?if ($name == 'RoleId'):?>
                      <?=\CHtml::activeDropDownList($formProduct, 'Attributes['.$name.']', \CHtml::listData($event->getRoles(), 'Id', 'Title'), ['value' => isset($formProduct->Attributes[$name]) ? $formProduct->Attributes[$name] : '']);?>
                      <span class="help-block m-top_5">Если нужного вам статуса нет в списке, тогда его нужно привязать к мероприятию в настройках интерфейса партнера.</span>
                    <?else:?>
                      <?=\CHtml::activeTextField($formProduct, 'Attributes['.$name.']', ['value' => isset($formProduct->Attributes[$name]) ? $formProduct->Attributes[$name] : '']);?>
                    <?endif;?>
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

            <div class="control-group" style="margin-bottom: 0;">
              <div class="controls">
                <h5><?=$formProduct->getAttributeLabel('AdditionalAttributes');?></h5> <?=\CHtml::link(\Yii::t('app', 'Добавить атрибут'), '#', ['class' => 'btn btn-mini m-bottom_10 new-additional-attribute']);?>
              </div>
            </div>
            <div class="additional-attributes"></div>

            <div class="control-group">
              <?=\CHtml::activeLabel($formProduct, 'AdditionalAttributesTitle', ['class' => 'control-label']);?>
              <div class="controls">
                <?=\CHtml::activeTextField($formProduct, 'AdditionalAttributesTitle');?>
              </div>
            </div>

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
          <?=\CHtml::activeLabel($formNewProduct, 'Description', ['class' => 'control-label']);?>
          <div class="controls">
            <?=\CHtml::activeTextArea($formNewProduct, 'Description', ['class' => 'input-xxlarge', 'style' => 'height: 120px;']);?>
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
            <button type="submit" value="" class="btn btn-info"><?=\Yii::t('app', 'Добавить новый товар');?></button>
          </div>
        </div>
      <?=\CHtml::endForm();?>
    </div>
  </div>
  
  <script type="text/template" id="tpl__price-control-group">   
    <div class="controls">
      <input type="text" value="<%=Price%>" class="input-mini" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][Price]');?>" placeholder="<?=\Yii::t('app', 'Цена');?>" />
      <input type="text" value="<%=Title%>" class="" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][Title]');?>" placeholder="<?=\Yii::t('app', 'Описание');?>" />
      <input type="text" value="<%=StartDate%>" class="input-small" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][StartDate]');?>" /> &mdash;
      <input type="text" value="<%=EndDate%>" class="input-small" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][EndDate]');?>');?>" />
      <a href="#" class="btn btn-danger"><?=\Yii::t('app', 'Удалить');?></a>
      <input type="hidden" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][ProductId]');?>" value="<%=ProductId%>" />
      <input type="hidden" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][Id]');?>" value="<%=Id%>" />
      <input type="hidden" name="<?=\CHtml::activeName($formNewProduct, 'Prices[<%=i%>][Delete]');?>" value="" />
    </div>
  </script>

  <script type="text/template" id="tpl__additional-attribute-control-group">
    <div class="controls">
      <input type="text" value="<%=Name%>" name="<?=\CHtml::activeName($formNewProduct, 'AdditionalAttributes[<%=i%>][Name]');?>" class="input-small" placeholder="<?=\Yii::t('app', 'Символьный код');?>" />
      <input type="text" value="<%=Label%>" name="<?=\CHtml::activeName($formNewProduct, 'AdditionalAttributes[<%=i%>][Label]');?>" placeholder="<?=\Yii::t('app', 'Название');?>" />
      <select name="<?=\CHtml::activeName($formNewProduct, 'AdditionalAttributes[<%=i%>][Type]');?>" class="input-small">
        <%_.each(<?=json_encode(\pay\models\AdditionalAttribute::getTypes());?>, function(value) { %>
          <option value="<%=value%>" <%if(value==Type){%>selected="selected"<%}%>><%=value%></option>
        <% }); %>
      </select>
      <input type="text" value="<%=Order%>" class="input-mini" name="<?=\CHtml::activeName($formNewProduct, 'AdditionalAttributes[<%=i%>][Order]');?>" placeholder="<?=\Yii::t('app', 'Сортировка');?>" />
      <a href="#" class="btn btn-danger"><?=\Yii::t('app', 'Удалить');?></a>
    </div>
  </script>
</div>