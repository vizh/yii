<?/**
 * @var string $backUrl
 * @var \user\models\forms\admin\Edit $form
 */
?>
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

  var employments = [];
  <?foreach ($form->Employments as $employment):?>
    var employment = {
      'Id'         : '<?=$employment->Id;?>',
      'Company'    : '<?=\CHtml::encode($employment->Company);?>',
      'Position'   : '<?=\CHtml::encode($employment->Position);?>',
      'StartMonth' : '<?=$employment->StartMonth;?>',
      'StartYear'  : '<?=$employment->StartYear;?>',
      'EndMonth'   : '<?=$employment->EndMonth;?>',
      'EndYear'    : '<?=$employment->EndYear;?>',
      'Primary'    : '<?=$employment->Primary;?>',
      'Delete'     : '<?=$employment->Delete;?>'
    };
    <?if ($employment->hasErrors()):?>
    employment.Errors = <?=json_encode($employment->getErrors());?>;
    <?endif;?>
    employments.push(employment);
  <?endforeach;?>
</script>

<?=\CHtml::beginForm('', 'POST', ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']);?>
<div class="btn-toolbar">
  <?if (!empty($backUrl)):?>
    <a href="<?=$backUrl;?>" class="btn"><?=\Yii::t('app', 'Вернуться к списку');?></a>
  <?endif;?>
  <button class="btn btn-success" type="submit"><?=\Yii::t('app', 'Сохранить');?></button>
</div>
<div class="well">
  <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
  <?if (\Yii::app()->getUser()->hasFlash('success')):?>
    <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
  <?endif;?>
  <div class="control-group">
    <label class="control-label"><?=\Yii::t('app', 'Дата регистрации');?></label>
    <div class="controls m-top_5">
      <b><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $user->CreationTime);?></b>
    </div>
  </div>
    <div class="control-group">
        <label class="control-label" for="NewRunetId">RUNET-ID</label>
        <div class="controls">
            <input id="NewRunetId" type="text" name="NewRunetId" value="<?=$user->RunetId;?>"/>
        </div>
    </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'FirstName', ['class' => 'control-label']);?>
    <div class="controls">
      <?foreach ($form->getLocaleList() as $locale):?>
        <div class="input-append">
          <?=\CHtml::activeTextField($form, 'FirstName['.$locale.']')?>
          <span class="add-on"><?=$locale;?></span>
        </div>
      <?endforeach;?>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'LastName', ['class' => 'control-label']);?>
    <div class="controls">
      <?foreach ($form->getLocaleList() as $locale):?>
        <div class="input-append">
          <?=\CHtml::activeTextField($form, 'LastName['.$locale.']')?>
          <span class="add-on"><?=$locale;?></span>
        </div>
      <?endforeach;?>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'FatherName', ['class' => 'control-label']);?>
    <div class="controls">
      <?foreach ($form->getLocaleList() as $locale):?>
        <div class="input-append">
          <?=\CHtml::activeTextField($form, 'FatherName['.$locale.']')?>
          <span class="add-on"><?=$locale;?></span>
        </div>
      <?endforeach;?>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Email', ['class' => 'control-label']);?>
    <div class="controls">
      <?=\CHtml::activeTextField($form, 'Email', ['class' => 'input-xlarge']);?>
    </div>
  </div>
  <div class="control-group employments">
    <?=\CHtml::activeLabel($form, 'Employments', ['class' => 'control-label']);?>
    <div class="controls">
      <div class="m-top_5 add">
        <a href="#" class="pseudo-link iconed-link"><i class="icon-plus-sign"></i> <span><?=\Yii::t('app', 'Добавить место работы');?></span></a>
      </div>
    </div>
  </div>
  <div class="control-group phones">
    <?=\CHtml::activeLabel($form, 'Phones', ['class' => 'control-label']);?>
    <div class="controls">
      <div class="m-top_5 add">
        <a href="#" class="pseudo-link iconed-link"><i class="icon-plus-sign"></i> <span><?=\Yii::t('app', 'Добавить номер телефона');?></span></a>
      </div>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Address', ['class' => 'control-label']);?>
    <?$this->widget('\contact\widgets\AddressControls', array('form' => $form->Address, 'address' => false, 'place' => false));?>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Visible', ['class' => 'control-label']);?>
    <div class="controls">
      <?=\CHtml::activeCheckBox($form, 'Visible');?>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Subscribe', ['class' => 'control-label']);?>
    <div class="controls">
      <?=\CHtml::activeCheckBox($form, 'Subscribe');?>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'NewPassword', ['class' => 'control-label']);?>
    <div class="controls">
      <?=\CHtml::activeTextField($form, 'NewPassword');?>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Photo', ['class' => 'control-label']);?>
    <div class="controls">
      <label class="checkbox">
        <?=\CHtml::activeCheckBox($form, 'DeletePhoto');?> <?=$form->getAttributeLabel('DeletePhoto');?>
      </label>
      <div class="help-block"><img src="<?=$user->getPhoto()->get50px();?>" /></div>
      <?=\CHtml::activeFileField($form, 'Photo');?>
    </div>
  </div>
</div>
<?=\CHtml::endForm();?>

<script type="text/template" id="phone-item-tpl">
  <div class="m-bottom_5 phone">
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
  <div class="m-bottom_5 <%if(Delete == 1){%>hide<%}%> phone">
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

<script type="text/template" id="career-item-tpl">
  <div class="m-bottom_10 m-top_5 well">
    <div class="form-row">
      <?=\CHtml::activeLabel($form, 'Company');?>
      <div class="form-inline">
        <input type="text" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Company]');?>" value="" class="span5"/>
        <label class="radio">
          <input type="radio" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Primary]');?>" value="1"> <?=$form->getAttributeLabel('Primary');?>
        </label>
      </div>
    </div>
    <div class="form-row">
      <?=\CHtml::activeLabel($form, 'Position', ['class' => 'm-top_5']);?>
      <input type="text" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Position]');?>" value="" class="span5"/>
    </div>
    <div class="form-row form-row-date">
      <label><?=\CHtml::activeLabel($form, 'Date', ['class' => 'm-top_5']);?></label>
      <div class="form-inline">
        <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][StartMonth]');?>">
          <?=$form->getMonthOptions();?>
        </select>
        <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][StartYear]');?>">
          <?=$form->getYearOptions();?>
        </select>
        <span class="mdash">&mdash;</span>
        <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][EndMonth]');?>">
          <?=$form->getMonthOptions();?>
        </select>
        <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][EndYear]');?>">
          <?=$form->getYearOptions();?>
        </select>
        <label class="checkbox">
          <input type="checkbox" /> <?=\Yii::t('app', 'По настоящее время');?>
        </label>
      </div>
    </div>
    <div class="form-row form-row-remove m-top_5">
      <a href="#" class="pseudo-link iconed-link" data-action="remove"><i class="icon-minus-sign"></i> <span><?=\Yii::t('app', 'Удалить');?></span></a>
    </div>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Delete]');?>" value="" />
  </div>
</script>

<script type="text/template" id="career-item-withdata-tpl">
  <div class="m-bottom_10 m-top_5 <%if(Delete == 1){%>hide<%}%> <%if(Primary == true){%>primary<%}%> well">
    <%if(typeof Errors != "undefined"){%>
      <div class="alert alert-error errorSummary"></div>
    <%}%>
    <div class="form-row">
      <?=\CHtml::activeLabel($form, 'Company');?>
      <div class="form-inline">
        <input type="text" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Company]');?>" value="<%=Company%>" class="span5"/>
        <label class="radio">
          <input type="radio" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Primary]');?>" <%if(Primary == true){%>checked<%}%> value="1"> <?=$form->getAttributeLabel('Primary');?>
            </label>
    </div>
  </div>
    <div class="form-row">
      <?=\CHtml::activeLabel($form, 'Position', ['class' => 'm-top_5']);?>
      <input type="text" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Position]');?>" value="<%=Position%>" class="span5"/>
    </div>
    <div class="form-row form-row-date">
      <label class="m-top_5"><?=\CHtml::activeLabel($form, 'Date');?></label>
      <div class="form-inline">
        <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][StartMonth]');?>" data-selected="<%=StartMonth%>">
          <?=$form->getMonthOptions();?>
        </select>
        <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][StartYear]');?>" data-selected="<%=StartYear%>">
          <?=$form->getYearOptions();?>
        </select>
        <span class="mdash">&mdash;</span>
        <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][EndMonth]');?>" data-selected="<%=EndMonth%>">
          <?=$form->getMonthOptions();?>
        </select>
        <select class="custom-select" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][EndYear]');?>" data-selected="<%=EndYear%>">
          <?=$form->getYearOptions();?>
        </select>
        <label class="checkbox">
          <input type="checkbox" <%if(EndMonth == '' && EndYear == ''){%>checked<%}%>/> <?=\Yii::t('app', 'По настоящее время');?>
        </label>
      </div>
    </div>
    <div class="form-row form-row-remove m-top_5">
      <a href="#" class="pseudo-link iconed-link" data-action="remove"><i class="icon-minus-sign"></i> <span><?=\Yii::t('app', 'Удалить');?></span></a>
    </div>
    <%if(Id != ''){%>
      <input type="hidden" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Id]');?>" value="<%=Id%>" />
    <%}%>
    <input type="hidden" name="<?=\CHtml::activeName($form, 'Employments[<%=i%>][Delete]');?>" value="" />
  </div>
</script>