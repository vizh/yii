<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Компании');?></span>
    </div>
  </div>
</h2>

<div class="container">
  <?=\CHtml::beginForm('','POST',array('class' => 'form-inline form-filter span12'));?>
    <?=\CHtml::activeDropDownList($filter, 'City', $filter->getCityList());?>
    <div class="pull-right">
      <?=\CHtml::activeTextField($filter, 'Query', array('class' => 'span8', 'placeholder' => \Yii::t('app', 'Поиск')));?>
      <?=\CHtml::imageButton('/images/search-type-image-light.png', array('width' => 20, 'height' => 19, 'class' => 'form-element_image'));?>
    </div>
  <?=\CHtml::endForm();?>
</div>

<div class="companies-list">
  <div class="container">
    <div class="row">
      <div class="span8 offset2">
        <table class="table">
          <tbody>
            <?php foreach ($companies as $company):?>
            <tr>
              <td class="span1">
                <a href="<?php echo $this->createUrl('/company/view/index', array('companyId' => $company->Id));?>">
                  <?=\CHtml::image($company->getLogo(), $company->Name, array('width' => 58));?>
                </a>
              </td>
              <td class="span3">
                <h4 class="title">
                  <a href="<?php echo $this->createUrl('/company/view/index', array('companyId' => $company->Id));?>"><?php echo $company->Name;?></a>
                </h4>
                
                <?if ($company->LinkAddress !== null):?>
                <p class="location"><?=$company->LinkAddress->Address->City->Name;?></p>
                <?endif;?>
                <p class="employees"><?=\Yii::t('app', '<b>{n}</b> сотрудник|<b>{n}</b> сотрудника|<b>{n}</b> сотрудников|<b>{n}</b> сотрудника', sizeof($company->Employments));?></p>
              </td>
              <td class="span2">
                <?foreach ($company->LinkPhones as $linkPhone):?>
                <p><?=$linkPhone->Phone;?></p>
                <?php endforeach;?>
              </td>
              <td class="span2 t-right">
                <?foreach ($company->LinkEmails as $linkEmail):?>
                <p><?=\CHtml::mailto($linkEmail->Email->Email);?></p>
                <?php endforeach;?>
                
                <?if ($company->LinkSite !== null):?>
                <p><?=\CHtml::link($company->LinkSite->Site->Url, $company->LinkSite->Site);?></p>
                <?endif;?>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php
  $this->widget('application\widgets\Paginator', array(
    'count' => $allCompanyCount, 
    'perPage' => \Yii::app()->params['CompanyPerPage']
  ));
?>
