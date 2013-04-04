<?=$this->renderPartial('parts/title');?>
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
              <h4><?=\Yii::t('app', 'Карьера');?></h4>
            </div>

            <?=$this->renderPartial('parts/form-alert', array('form' => $form));?>

            <div class="user-career-items"></div>

            <div class="form-row form-row-add">
              <a href="#" class="pseudo-link iconed-link" data-action="career_add"><i class="icon-plus-sign"></i> <span>Добавить место работы</span></a>
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

<script type="text/javascript">
  var employments = [];
  <?foreach ($user->Employments as $employment):?>
    employments.push({
      'Id'         : '<?=$employment->Id;?>',
      'Company'    : '<?=addslashes($employment->Company->Name);?>',
      'Position'   : '<?=addslashes($employment->Position);?>',
      'StartMonth' : '<?=$employment->StartMonth;?>',
      'StartYear'  : '<?=$employment->StartYear;?>',
      'EndMonth'   : '<?=$employment->EndMonth;?>',
      'EndYear'    : '<?=$employment->EndYear;?>',
      'Primary'    : '<?=$employment->Primary;?>'
    });
  <?endforeach;?>
</script>

<script type="text/template" id="career-item-tpl">
  <div class="user-career-item">
    <div class="form-row">
      <?=\CHtml::activeLabel($form, 'Company');?>
      <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][Company]');?>" value="" class="span5"/>
    </div>
    <div class="form-row">
      <?=\CHtml::activeLabel($form, 'Position');?>
      <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][Position]');?>" value="" class="span5"/>
    </div>
    <div class="form-row form-row-date">
      <label><?=\CHtml::activeLabel($form, 'Date');?></label>
      <select class="custom-select" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][StartMonth]');?>">
        <?=$form->getMonthOptions();?>
      </select>
      <select class="custom-select" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][StartYear]');?>">
        <?=$form->getYearOptions();?>
      </select>
      <span class="mdash">&mdash;</span>
      <select class="custom-select" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][EndMonth]');?>">
        <?=$form->getMonthOptions();?>       
      </select>
      <select class="custom-select" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][EndYear]');?>">
        <?=$form->getYearOptions();?>
      </select>
      <label class="checkbox pull-right" style="margin-right:120px; margin-top:5px">
        <input type="checkbox" /> <?=\Yii::t('app', 'По настоящее время');?>
      </label>
    </div>
    <div class="form-row">
      <label class="checkbox">
        <input type="checkbox" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][Primary]');?>" value="1"> <?=$form->getAttributeLabel('Primary');?>
      </label>
    </div>
    <div class="form-row form-row-remove">
      <a href="#" class="pseudo-link iconed-link" data-action="remove"><i class="icon-minus-sign"></i> <span><?=\Yii::t('app', 'Удалить');?></span></a>
    </div>
    <input type="hidden" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][Deleted]');?>" value="" />
  </div>
</script>

<script type="text/template" id="career-item-withdata-tpl">
  <div class="user-career-item">
    <div class="form-row">
      <?=\CHtml::activeLabel($form, 'Company');?>
      <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][Company]');?>" value="<%=Company%>" class="span5"/>
    </div>
    <div class="form-row">
      <?=\CHtml::activeLabel($form, 'Position');?>
      <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][Position]');?>" value="<%=Position%>" class="span5"/>
    </div>
    <div class="form-row form-row-date">
      <label><?=\CHtml::activeLabel($form, 'Date');?></label>
      <select class="custom-select" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][StartMonth]');?>" data-selected="<%=StartMonth%>">
        <?=$form->getMonthOptions();?>
      </select>
      <select class="custom-select" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][StartYear]');?>" data-selected="<%=StartYear%>">
        <?=$form->getYearOptions();?>
      </select>
      <span class="mdash">&mdash;</span>
      <select class="custom-select" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][EndMonth]');?>" data-selected="<%=EndMonth%>">
        <?=$form->getMonthOptions();?>       
      </select>
      <select class="custom-select" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][EndYear]');?>" data-selected="<%=EndYear%>">
        <?=$form->getYearOptions();?>
      </select>
      <label class="checkbox pull-right" style="margin-right:120px; margin-top:5px">
        <input type="checkbox" <%if(EndMonth == '' && EndYear == ''){%>checked<%}%>/> <?=\Yii::t('app', 'По настоящее время');?>
      </label>
    </div>
    <div class="form-row">
      <label class="checkbox">
        <input type="checkbox" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][Primary]');?>" <%if(Primary == true){%>checked<%}%> value="1"> <?=$form->getAttributeLabel('Primary');?>
      </label>
    </div>
    <div class="form-row form-row-remove">
      <a href="#" class="pseudo-link iconed-link" data-action="remove"><i class="icon-minus-sign"></i> <span><?=\Yii::t('app', 'Удалить');?></span></a>
    </div>
    <input type="hidden" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][Id]');?>" value="<%=Id%>" />
    <input type="hidden" name="<?=\CHtml::resolveName($form, $_ = 'Employments[<%=i%>][Deleted]');?>" value="" />
  </div>
</script>