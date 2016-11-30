<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Редактирование компании')?></span>
    </div>
  </div>
</h2>

<script type="text/javascript">
  var phones = [];
  <?foreach($form->Phones as $phone):?>
    var phone = {
      'Id' : '<?=$phone->Id?>',
      'Phone' : '<?=$phone->OriginalPhone?>',
      'Delete' : '<?=$phone->Delete?>'
    };
    <?if($phone->hasErrors()):?>
      phone.Errors = <?=json_encode($phone->getErrors())?>;
    <?endif?>
    phones.push(phone);
  <?endforeach?>

  var emails = [];
  <?foreach($form->Emails as $email):?>
    var email = {
      'Id' : '<?=$email->Id?>',
      'Email' : '<?=$email->Email?>',
      'Title' : '<?=$email->Title?>',
      'Delete' : '<?=$email->Delete?>'
    };
    <?if($email->hasErrors()):?>
      email.Errors = <?=json_encode($email->getErrors())?>;
    <?endif?>
    emails.push(email);
  <?endforeach?>
</script>

<div class="container company-edit">
  <div class="row">
    <div class="span3">
      <p>Указаная вами информация будет отображаться в публичном профиле компании. Пожалуйста, убедитесь в ее актуальности и корректности.</p>
      <p>В случае, если будет выявления попытка публикации недостоверной или заведомо ложной информации, администрация RUNET-ID оставляет за собой право лишить вас доступа к управлению профилем компании или блокировки аккаунта.</p>
    </div>
    <div class="span9">
      <?=\CHtml::errorSummary($form,'<div class="alert alert-error">', '</div>')?>
      <?if(\Yii::app()->getUser()->hasFlash('success')):?>
        <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success')?></div>
      <?endif?>

      <?=\CHtml::form('', 'POST', array('class' => 'b-form', 'enctype' => 'multipart/form-data'))?>
        <div class="form-row">
          <?=\CHtml::activeLabel($form, 'Logo')?>
          <div class="row">
            <div class="span3">
              <?=\CHtml::activeFileField($form, 'Logo')?>
            </div>
            <div class="span3">
              <?=\CHtml::image($company->getLogo()->get58px())?>
            </div>
          </div>
        </div>

        <div class="form-row">
          <?=\CHtml::activeLabel($form, 'Name')?>
          <?=\CHtml::activeTextField($form, 'Name')?>
        </div>

        <div class="form-row">
          <?=\CHtml::activeLabel($form, 'FullName')?>
          <?=\CHtml::activeTextField($form, 'FullName', array('class' => 'input-block-level'))?>
        </div>


        <div class="form-row m-bottom_10">
          <?=\CHtml::activeLabel($form, 'FullInfo')?>
          <?=\CHtml::activeTextArea($form, 'FullInfo', array('class' => 'input-block-level'))?>
        </div>

        <div class="form-row">
          <?=\CHtml::activeLabel($form, 'Site')?>
          <?=\CHtml::activeTextField($form, 'Site')?>
        </div>

        <div class="form-row">
          <?=\CHtml::activeLabel($form, 'Address')?>
          <?$this->widget('\contact\widgets\AddressControls', array('form' => $form->Address))?>
        </div>

        <div class="form-row phone-items m-bottom_30">
          <?=\CHtml::activeLabel($form, 'Phones')?>
          <div class="controls-add">
             <a href="#" class="pseudo-link"><?=\Yii::t('app', 'Добавить телефон')?></a>
          </div>
        </div>

        <div class="form-row email-items">
          <?=\CHtml::activeLabel($form, 'Emails')?>
          <div class="controls-add">
            <a href="#" class="pseudo-link"><?=\Yii::t('app', 'Добавить эл.почту')?></a>
          </div>
        </div>

        <div class="form-footer">
          <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-info'))?>
        </div>
      <?=\CHtml::endForm()?>
    </div>
  </div>
</div>

<script type="text/template" id="phone-item-tpl">
  <div class="controls">
    <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][OriginalPhone]')?>" class="input-xlarge" />
    <a href="#" class="pseudo-link" data-action="remove"><?=\Yii::t('app', 'Удалить')?></a>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Delete]')?>"/>
  </div>
</script>

<script type="text/template" id="phone-item-withdata-tpl">
  <div class="controls <%if(Delete == 1 && typeof Errors == "undefined"){%>hide<%}%>">
    <%if(typeof Errors != "undefined"){%>
      <div class="alert alert-error errorSummary"></div>
    <%}%>
    <input type="text" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][OriginalPhone]')?>" class="input-xlarge" value="<%=Phone%>" />
    <a href="#" class="pseudo-link" data-action="remove"><?=\Yii::t('app', 'Удалить')?></a>
    <%if(Id != ''){%>
      <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Id]')?>" value="<%=Id%>"/>
    <%}%>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Phones[<%=i%>][Delete]')?>" <%if(Delete == 1){%>value="1"<%}%>/>
  </div>
</script>

<script type="text/template" id="email-item-tpl">
  <div class="controls">
    <input type="text" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Email]')?>" placeholder="<?=\Yii::t('app','Адрес')?>"/>
    <input type="text" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Title]')?>" class="input-medium" placeholder="<?=\Yii::t('app','Описание')?>"/>
    <a href="#" class="pseudo-link" data-action="remove"><?=\Yii::t('app', 'Удалить')?></a>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Delete]')?>"/>
  </div>
</script>

<script type="text/template" id="email-item-withdata-tpl">
  <div class="controls <%if(Delete == 1){%>hide<%}%>">
    <%if(typeof Errors != "undefined"){%>
      <div class="alert alert-error errorSummary"></div>
    <%}%>
    <input type="text" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Email]')?>" value="<%=Email%>" placeholder="<?=\Yii::t('app','Адрес')?>"/>
    <input type="text" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Title]')?>" class="input-medium" value="<%=Title%>" placeholder="<?=\Yii::t('app','Описание')?>"/>
    <a href="#" class="pseudo-link" data-action="remove"><?=\Yii::t('app', 'Удалить')?></a>
    <%if(Id != ''){%>
      <input type="hidden" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Id]')?>" value="<%=Id%>"/>
    <%}%>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Emails[<%=i%>][Delete]')?>" <%if(Delete == 1){%>value="1"<%}%>/>
  </div>
</script>

