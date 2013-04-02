<?=$this->renderPartial('parts/title');?>
<script type="text/javascript">
  var phones = [];
  <?foreach ($user->LinkPhones as $linkPhone):?>
    phones.push({
      'Id' : '<?=$linkPhone->Phone->Id;?>',
      'CountryCode' : '<?=$linkPhone->Phone->CountryCode;?>',
      'CityCode' : '<?=$linkPhone->Phone->CityCode;?>',
      'Phone' : '<?=$linkPhone->Phone->Phone;?>'
    });
  <?endforeach;?>
</script>

<div class="user-account-settings">
  <div class="clearfix">
    <div class="container">
      <div class="row">
        <div class="span3">
          <?=$this->renderPartial('parts/nav', array('current' => $this->getAction()->getId()));?>
        </div>
        <div class="span9">
          <?=\CHtml::form('', 'POST', array('class' => 'b-form'));?>
            <div class="form-header">
              <h4><?=\Yii::t('app', 'Контактная информация');?></h4>
            </div>

            <?=$this->renderPartial('parts/form-alert', array('form' => $form));?>
              <div class="form-row">
                <?=\CHtml::activeLabel($form, 'Email');?>
                <?=\CHtml::activeTextField($form, 'Email', array('class' => 'span5'));?>
              </div>

              <div class="form-row">
                <?=\CHtml::activeLabel($form, 'Site');?>
                <?=\CHtml::activeTextField($form, 'Site', array('class' => 'span5'));?>
              </div>

              <div class="user-phone-items">
                <div class="form-row"><?=\CHtml::activeLabel($form, 'Phone');?></div>
                <div class="form-row form-row-add">
                  <a href="#" class="pseudo-link iconed-link"><i class="icon-plus-sign"></i> <span><?=\Yii::t('app', 'Добавить номер телефона');?></span></a>
                </div>
              </div>
              
              <div class="user-account-items m-top_10">
                <?=\CHtml::activeLabel($form, 'Accounts');?>
              </div>

              <div class="form-row">
                <a href="#" class="pseudo-link iconed-link" data-action="account_add"><i class="icon-plus-sign"></i> <span>Добавить аккаунт в социальной сети</span></a>
              </div>

              <div class="form-footer">
                <input type="submit" value="Сохранить" class="btn btn-info">
              </div>
          <?=\CHtml::endForm();?>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/template" id="phone-item-tpl">
  <div class="form-row">
    <span>+</span> <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Phones[<%=i%>]CountryCode');?>" class="input-mini" />
    <span>(</span> <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Phones[<%=i%>]CityCode');?>" class="input-small" /> <span>)</span>
    <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Phones[<%=i%>]Phone');?>" class="input-medium" />
    <select name="<?=\CHtml::resolveName($form, $_ = 'Phones[<%=i%>]Type');?>" class="input-medium">
      <?=$form->getPhoneTypeOptions();?>
    </select>
    <a href="#" class="pseudo-link delete-phone-link" data-action="remove"><?=\Yii::t('app', 'Удалить');?></a>
    <input type="hidden" name="<?=\CHtml::resolveName($form, $_ = 'Phones[<%=i%>]Delete');?>"/>
  </div>
</script>

<script type="text/template" id="phone-item-withdata-tpl">
  <div class="form-row">
    <span>+</span> <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Phones[<%=i%>]CountryCode');?>" class="input-mini" value="<%=CountryCode%>" />
    <span>(</span> <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Phones[<%=i%>]CityCode');?>" class="input-small" value="<%=CityCode%>" /> <span>)</span>
    <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Phones[<%=i%>]Phone');?>" class="input-medium" value="<%=Phone%>" />
    <a href="#" class="pseudo-link delete-phone-link" data-action="remove"><?=\Yii::t('app', 'Удалить');?></a>
    <input type="hidden" name="<?=\CHtml::resolveName($form, $_ = 'Phones[<%=i%>]Id');?>" value="<%=Id%>"/>
    <input type="hidden" name="<?=\CHtml::resolveName($form, $_ = 'Phones[<%=i%>]Delete');?>"/>
  </div>
</script>