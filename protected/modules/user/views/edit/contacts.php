<?
use user\models\User;
/**
 * @var User $user
 */
?>

<?=$this->renderPartial('parts/title');?>
<script type="text/javascript">
  var phones = [];
  <?foreach ($form->Phones as $phone):?>
    var phone = {
      'Id' : '<?=$phone->Id;?>',
      'Phone' : '<?=$phone->OriginalPhone;?>',
      'Type' : '<?=$phone->Type;?>',
      'Delete' : '<?=$phone->Delete;?>'
    };
    <?if ($phone->hasErrors()):?>
      phone.Errors = <?=json_encode($phone->getErrors());?>;
    <?endif;?>
    phones.push(phone);
  <?endforeach;?>
  
  var accounts = [];
  <?foreach ($form->Accounts as $account):?>
    var account = {
      'Id' : '<?=$account->Id;?>',
      'TypeId' : '<?=$account->TypeId;?>',
      'Account' : '<?=\CHtml::encode($account->Account);?>',
      'Delete' : '<?=$account->Delete;?>'
    };
    <?if ($account->hasErrors()):?>
      account.Errors = <?=json_encode($account->getErrors());?>;
    <?endif;?>
    accounts.push(account);
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
                <?=\CHtml::activeLabel($form, 'Address');?>
                <?$this->widget('\contact\widgets\AddressControls', array('form' => $form->Address, 'address' => false, 'place' => false));?>
              </div>
          
              <div class="form-row">
                <?=\CHtml::activeLabel($form, 'Email');?>
                <?=\CHtml::activeTextField($form, 'Email', array('class' => 'span5'));?>
              </div>

              <div class="form-row">
                <?=\CHtml::activeLabel($form, 'PrimaryPhone');?>
                <?=\CHtml::activeTextField($form, 'PrimaryPhone', array('class' => 'span5'));?>
              </div>
              <?if (!empty($user->PrimaryPhone) && !$user->PrimaryPhoneVerify):?>
                <div class="alert alert-warning" id="primaryphone-verify">
                  <p><strong><?=\Yii::t('app', 'Телефон не подтвержден. Пожалуйста подтвердите номер телефона.');?></strong></p>
                  <button class="btn send"><?=\Yii::t('app', 'Отправить код подтверждения');?></button>
                  <p class="text-error hide m-top_5" style="margin-bottom: 0;"></p>
                </div>
              <?endif;?>

              <div class="user-phone-items">
                <div class="form-row"><?=\CHtml::activeLabel($form, 'Phones');?></div>
                <div class="form-row form-row-add">
                  <a href="#" class="pseudo-link iconed-link"><i class="icon-plus-sign"></i> <span><?=\Yii::t('app', 'Добавить номер телефона');?></span></a>
                </div>
              </div>

              <div class="form-row">
                <?=\CHtml::activeLabel($form, 'Site');?>
                <?=\CHtml::activeTextField($form, 'Site', array('class' => 'span5'));?>
              </div>
              
              <div class="user-account-items m-top_20">
                <div class="form-row"><?=\CHtml::activeLabel($form, 'Accounts');?></div>
                <div class="form-row form-row-add">
                  <a href="#" class="pseudo-link iconed-link"><i class="icon-plus-sign"></i> <span><?=\Yii::t('app', 'Добавить аккаунт в социальной сети');?></span></a>
                </div>
              </div>

              <div class="form-footer">
                <?=\CHtml::submitButton(\Yii::t('app','Сохранить'), array('class' => 'btn btn-info'));?>
              </div>
          <?=\CHtml::endForm();?>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/template" id="phone-item-tpl">
  <div class="form-row">
    <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][OriginalPhone]');?>" class="input-xlarge" />
    <select name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Type]');?>" class="input-medium">
      <?foreach($form->getPhoneTypeData() as $type => $title):?>
        <option value="<?=$type;?>"><?=$title;?></option>
      <?endforeach;?>
    </select>
    <a href="#" class="pseudo-link delete-phone-link" data-action="remove"><?=\Yii::t('app', 'Удалить');?></a>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Delete]');?>"/>
  </div>
</script>

<script type="text/template" id="phone-item-withdata-tpl">
  <div class="form-row <%if(Delete == 1){%>hide<%}%>">
    <%if(typeof Errors != "undefined"){%>
      <div class="alert alert-error errorSummary"></div>
    <%}%>
    <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][OriginalPhone]');?>" class="input-xlarge" value="<%=Phone%>" />
    <select name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Type]');?>" class="input-medium">
      <?foreach($form->getPhoneTypeData() as $type => $title):?>
        <option value="<?=$type;?>" <%if(Type == '<?=$type;?>'){%>selected="selected"<%}%>><?=$title;?></option>
      <?endforeach;?>
    </select>
    <a href="#" class="pseudo-link delete-phone-link" data-action="remove"><?=\Yii::t('app', 'Удалить');?></a>
    <%if(Id != ''){%>
      <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Id]');?>" value="<%=Id%>"/>
    <%}%>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Delete]');?>" <%if(Delete == 1){%>value="1"<%}%>/>
  </div>
</script>

<script type="text/template" id="account-item-tpl">
  <div class="form-row">
    <input type="text" name="<?=\CHtml::activeName($form, 'Accounts[<%=i%>][Account]');?>" />
    <select name="<?=\CHtml::activeName($form, 'Accounts[<%=i%>][TypeId]');?>" class="input-medium">
      <?foreach($form->getAccountTypeData() as $type => $title):?>
        <option value="<?=$type;?>"><?=$title;?></option>
      <?endforeach;?>
    </select>
    <a href="#" class="pseudo-link delete-phone-link" data-action="remove"><?=\Yii::t('app', 'Удалить');?></a>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Delete]');?>"/>
  </div>
</script>

<script type="text/template" id="account-item-withdata-tpl">
  <div class="form-row <%if(Delete == 1){%>hide<%}%>">
    <%if(typeof Errors != "undefined"){%>
      <div class="alert alert-error errorSummary"></div>
    <%}%>
    <input type="text" name="<?=\CHtml::activeName($form, 'Accounts[<%=i%>][Account]');?>" value="<%=Account%>"/>
    <select name="<?=\CHtml::activeName($form, 'Accounts[<%=i%>][TypeId]');?>" class="input-medium">
      <?foreach($form->getAccountTypeData() as $typeId => $title):?>
        <option value="<?=$typeId;?>" <%if(TypeId == '<?=$typeId;?>'){%>selected="selected"<%}%>><?=$title;?></option>
      <?endforeach;?>
    </select>
    <a href="#" class="pseudo-link delete-phone-link" data-action="remove"><?=\Yii::t('app', 'Удалить');?></a>
    <%if(Id != ''){%>
      <input type="hidden" name="<?=\CHtml::activeName($form, 'Accounts[<%=i%>][Id]');?>" value="<%=Id%>"/>
    <%}%>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Accounts[<%=i%>][Delete]');?>" <%if(Delete == 1){%>value="1"<%}%>/>
  </div>
</script>

<script type="text/template" id="primaryphone-verify-form-tpl">
  <form class="form-inline" style="margin-bottom: 0;">
    <input type="text" name="" placeholder="<?=\Yii::t('app', 'Код подтверждения');?>" />
    <button class="btn"><?=\Yii::t('app', 'Подтвердить');?></button>
    <a href="#" class="send pseudo-link" data-delay="<?=(\user\controllers\ajax\PhoneVerifyAction::VERIFY_SEND_DELAY * 1000);?>" style="margin-left: 20px;"><small><?=\Yii::t('app', 'Отправить код повтоно');?></small></a>
  </form>
</script>