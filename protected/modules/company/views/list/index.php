<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Компании')?></span>
    </div>
  </div>
</h2>

<div class="container">
  <?=\CHtml::beginForm($this->createUrl('/company/list/index'),'get',array('class' => 'form-inline form-filter span12'))?>
    <?=\CHtml::activeDropDownList($filter, 'CityId', $filter->getCityList(), array('name' => 'Filter[CityId]'))?>
    <div class="pull-right">
      <?=\CHtml::activeTextField($filter, 'Query', array('class' => 'span8', 'placeholder' => \Yii::t('app', 'Поиск'), 'name' => 'Filter[Query]'))?>
      <?=\CHtml::imageButton('/images/search-type-image-light.png', array('width' => 20, 'height' => 19, 'class' => 'form-element_image'))?>
    </div>
  <?=\CHtml::endForm()?>
</div>

<div class="companies-list">
  <div class="container">
    <div class="row">
      <div class="span8 offset2">
        <table class="table">
          <tbody>
            <?foreach($companies as $company):?>
            <tr>
              <td class="span1">
                <a href="<?=$this->createUrl('/company/view/index', array('companyId' => $company->Id))?>">
                  <?=\CHtml::image($company->getLogo()->get58px(), $company->Name)?>
                </a>
              </td>
              <td class="span3">
                <h4 class="title">
                  <a href="<?=$this->createUrl('/company/view/index', array('companyId' => $company->Id))?>"><?=$company->Name?></a>
                </h4>

                <?if($company->LinkAddress !== null && $company->LinkAddress->Address->City !== null):?>
                <p class="location"><?=$company->LinkAddress->Address->City->Name?></p>
                <?endif?>
                <p class="employees"><?=\Yii::t('app', '<b>{n}</b> сотрудник|<b>{n}</b> сотрудника|<b>{n}</b> сотрудников|<b>{n}</b> сотрудника', sizeof($company->Employments))?></p>
              </td>
              <td class="span2">
                <?foreach($company->LinkPhones as $linkPhone):?>
                <p><?=$linkPhone->Phone?></p>
                <?endforeach?>
              </td>
              <td class="span2 t-right">
                <?foreach($company->LinkEmails as $linkEmail):?>
                <p><?=\CHtml::mailto($linkEmail->Email->Email)?></p>
                <?endforeach?>

                <?if($company->LinkSite !== null):?>
                <p><?=\CHtml::link($company->LinkSite->Site->Url, $company->LinkSite->Site)?></p>
                <?endif?>
              </td>
            </tr>
            <?endforeach?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php
  $this->widget('application\widgets\Paginator', array(
    'paginator' => $paginator
  ));
?>
