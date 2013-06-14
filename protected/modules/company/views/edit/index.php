<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Редактирование компании');?></span>
    </div>
  </div>
</h2>


<script type="text/javascript">
  var phones = [];
  <?foreach ($form->Phones as $phone):?>
    var phone = {
      'Id' : '<?=$phone->Id;?>',
      'CountryCode' : '<?=$phone->CountryCode;?>',
      'CityCode' : '<?=$phone->CityCode;?>',
      'Phone' : '<?=$phone->Phone;?>',
      'Delete' : '<?=$phone->Delete;?>'
    };
    <?if ($phone->hasErrors()):?>
      phone.Errors = <?=json_encode($phone->getErrors());?>;
    <?endif;?>
    phones.push(phone);
  <?endforeach;?>
    
  var emails = [];
  <?foreach ($form->Emails as $email):?>
    var email = {
      'Id' : '<?=$email->Id;?>',
      'Email' : '<?=$email->Email;?>',
      'Title' : '<?=$email->Title;?>',
      'Delete' : '<?=$email->Delete;?>'
    };
    <?if ($email->hasErrors()):?>
      email.Errors = <?=json_encode($email->getErrors());?>;
    <?endif;?>
    emails.push(email);
  <?endforeach;?>
</script>

<div class="company-edit">
  <?=\CHtml::form('', 'POST', array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'));?>
  <div class="container">
    <div class="row">
      <div class="span12">
        <?=\CHtml::errorSummary($form, '<div class="alert alert-error">','</div>');?>
        <?if (\Yii::app()->user->hasFlash('success')):?>
          <div class="alert alert-success"><?=\Yii::app()->user->getFlash('success');?></div>
        <?endif;?>
        
        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'Logo', array('class' => 'control-label'));?>
          <div class="controls">
            <?=\CHtml::activeFileField($form, 'Logo');?>
            <img src="<?=$company->getLogo()->get58px();?>" title="" />
          </div>
        </div>
        
        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'Name', array('class' => 'control-label'));?>
          <div class="controls">
            <?=\CHtml::activeTextField($form, 'Name');?>
          </div>
        </div>
        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'FullName', array('class' => 'control-label'));?>
          <div class="controls">
            <?=\CHtml::activeTextField($form, 'FullName', array('class' => 'input-block-level'));?>
          </div>
        </div>
        
        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'FullInfo', array('class' => 'control-label'));?>
          <div class="controls">
            <?=\CHtml::activeTextArea($form, 'FullInfo', array('class' => 'input-block-level'));?>
          </div>
        </div>
        
        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'Site', array('class' => 'control-label'));?>
          <div class="controls">
            <?=\CHtml::activeTextField($form, 'Site');?>
          </div>
        </div>
        
        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'Address', array('class' => 'control-label'));?>
          <?$this->widget('\contact\widgets\AddressControls', array('form' => $form->Address, 'place' => false));?>
        </div>
        
        <div class="control-group phone-items">
          <?=\CHtml::activeLabel($form, 'Phones', array('class' => 'control-label'));?>
          <div class="controls m-top_5 controls-add">
            <a href="#" class="pseudo-link"><?=\Yii::t('app', 'Добавить телефон');?></a>
          </div>
        </div>
        
        <div class="control-group email-items">
          <?=\CHtml::activeLabel($form, 'Emails', array('class' => 'control-label'));?>
          <div class="controls m-top_5 controls-add">
            <a href="#" class="pseudo-link"><?=\Yii::t('app', 'Добавить эл.почту');?></a>
          </div>
        </div>
        
        <div class="control-group">
          <div class="controls">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-info'));?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?=\CHtml::endForm();?>
</div>

<script type="text/template" id="phone-item-tpl">
  <div class="controls m-bottom_5">
    <span>+</span> <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][CountryCode]');?>" class="input-mini" />
    <span>(</span> <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][CityCode]');?>" class="input-small" /> <span>)</span>
    <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Phone]');?>" class="input-medium" />
    <a href="#" class="pseudo-link" data-action="remove"><?=\Yii::t('app', 'Удалить');?></a>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Delete]');?>"/>
  </div>
</script>

<script type="text/template" id="phone-item-withdata-tpl">
  <div class="controls <%if(Delete == 1){%>hide<%}%> m-bottom_5">
    <%if(typeof Errors != "undefined"){%>
      <div class="alert alert-error errorSummary"></div>
    <%}%>
    <span>+</span> <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][CountryCode]');?>" class="input-mini" value="<%=CountryCode%>" />
    <span>(</span> <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][CityCode]');?>" class="input-small" value="<%=CityCode%>" /> <span>)</span>
    <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Phone]');?>" class="input-medium" value="<%=Phone%>" />
    <a href="#" class="pseudo-link" data-action="remove"><?=\Yii::t('app', 'Удалить');?></a>
    <%if(Id != ''){%>
      <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Id]');?>" value="<%=Id%>"/>
    <%}%>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Delete]');?>" <%if(Delete == 1){%>value="1"<%}%>/>
  </div>
</script>

<script type="text/template" id="email-item-tpl">
  <div class="controls m-bottom_5">
    <input type="text" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Email]');?>" placeholder="<?=\Yii::t('app','Адрес');?>"/>
    <input type="text" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Title]');?>" class="input-medium" placeholder="<?=\Yii::t('app','Описание');?>"/>
    <a href="#" class="pseudo-link" data-action="remove"><?=\Yii::t('app', 'Удалить');?></a>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Delete]');?>"/>
  </div>
</script>

<script type="text/template" id="email-item-withdata-tpl">
  <div class="controls <%if(Delete == 1){%>hide<%}%> m-bottom_5">
    <%if(typeof Errors != "undefined"){%>
      <div class="alert alert-error errorSummary"></div>
    <%}%>
    <input type="text" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Email]');?>" value="<%=Email%>" placeholder="<?=\Yii::t('app','Адрес');?>"/>
    <input type="text" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Title]');?>" class="input-medium" value="<%=Title%>" placeholder="<?=\Yii::t('app','Описание');?>"/>          
    <a href="#" class="pseudo-link" data-action="remove"><?=\Yii::t('app', 'Удалить');?></a>
    <%if(Id != ''){%>
      <input type="hidden" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Id]');?>" value="<%=Id%>"/>
    <%}%>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Delete]');?>" <%if(Delete == 1){%>value="1"<%}%>/>
  </div>
</script>

