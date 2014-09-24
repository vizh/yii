<?php
/**
 * @var $coupons \pay\models\Coupon[]
 * @var $paginator \application\components\utility\Paginator
 * @var $form \partner\models\forms\coupon\Search
 * @var $products array
 * @var Event $event
 */
use event\models\Event;

?>

<div class="row">
  <div class="span12">
    <?=CHtml::beginForm(Yii::app()->createUrl('/partner/coupon/index/'), 'get');?>
    <div class="row">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Code');?>
        <?=CHtml::activeTextField($form, 'Code');?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Activator');?>
        <?=CHtml::activeTextField($form, 'Activator', ['placeholder' => 'RUNET-ID']);?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Discount');?>
        <?=CHtml::activeTextField($form, 'Discount');?>
      </div>
    </div>

    <div class="row">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Activated');?>
        <?=CHtml::activeDropDownList($form, 'Activated', $form->getListValues());?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Product');?>
        <?=CHtml::activeDropDownList($form, 'Product', $products);?>
      </div>
      <?if ($hasTicket):?>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Owner');?>
        <?=CHtml::activeTextField($form, 'Owner', ['placeholder' => 'RUNET-ID, ФИО, E-mail']);?>
      </div>
      <?endif;?>
    </div>

    <div class="row indent-top2">
      <div class="span4">
        <button class="btn btn-large" type="submit"><i class="icon-search"></i> Искать</button>
      </div>
      <div class="span4">
        <h4>Всего найдено: <?=$paginator->getCount();?></h4>
      </div>
    </div>
    <?=CHtml::endForm();?>
  </div>
</div>

<?if (!empty($coupons)):?>
<form action="<?=Yii::app()->createUrl('/partner/coupon/give');?> " method="GET">
<table class="table table-striped">
    <thead>
    <tr>
        <th><input type="checkbox" name="" value="" /></th>
        <th>Промо-код</th>
        <th>Скидка</th>
        <th>Продукт</th>
        <th>Выдан</th>
        <th>Активация</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($coupons as $coupon):?>
    <tr>
        <td>
          <?if (!$coupon->IsTicket):?>
            <input type="checkbox" name="Coupons[]" value="<?=$coupon->Code;?>" />
          <?endif;?>
        </td>
        <td><strong><?=$coupon->Code;?></strong></td>
        <td><strong><?=($coupon->Discount * 100);?> %</strong></td>
        <td>
            <?if (!empty($coupon->Products)):?>
                <?foreach ($coupon->Products as $product):?>
                    <span title="<?=$product->Title;?>">
                        <?=\application\components\utility\Texts::cropText($product->Title, 20);?>
                    </span><br>
                <?endforeach;?>
            <?else:?>
                &ndash;
            <?endif;?>
        </td>
        <td>
            <?if ($coupon->IsTicket):?>
              <span class="label label-important"><?=\Yii::t('app', 'Продан');?></span>
              <?if ($coupon->Owner->Temporary):?>
                <br/><span class="small"><?=$coupon->Owner->Email;?>, <?=$coupon->Owner->RunetId;?>
              <?else:?>
                <br/><a target="_blank" href="<?=\Yii::app()->createUrl('/user/view/index', array('runetId' => $coupon->Owner->RunetId));?>" class="small"><strong><?=$coupon->Owner->getFullName();?>, <?=$coupon->Owner->RunetId;?></strong></a>
              <?endif;?>
            <?elseif ($coupon->Recipient == null):?>
                <span class="label"><?=\Yii::t('app', 'Не выдан');?></span>
            <?else:?>
                <span class="label label-info"><?=\Yii::t('app', 'Выдан');?></span>
                <p>
                  <em><?=$coupon->Recipient;?></em>
                </p>
            <?endif;?>
        </td>
        <td>
            <?php if (!$coupon->Multiple && sizeof($coupon->Activations) > 0):?>
                <span class="label label-success">Активирован</span> 
                <br/><a target="_blank" href="<?=Yii::app()->createUrl('/user/view/index', array('runetId' => $coupon->Activations[0]->User->RunetId));?>" class="small"><strong><?=$coupon->Activations[0]->User->getFullName();?>, <?=$coupon->Activations[0]->User->RunetId;?></strong></a>
            <?php elseif ($coupon->Multiple):?>
                <span class="label <?=count($coupon->Activations) > 0 ? 'label-success' : '';?>">
                    Активирован <?=sizeof($coupon->Activations);?> из <?=$coupon->MultipleCount;?>
                </span>
            <?php else:?>
                <span class="label">Не активирован</span>
            <?php endif;?>
        </td>
        <td>
            <a target="_blank" title="Статистика" class="btn" href="<?=Yii::app()->createUrl('/partner/coupon/statistics', ['eventIdName' => $event->IdName, 'code' => $coupon->Code, 'hash' => $coupon->getHash()]);?>"><i class="icon-share"></i></a>
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td><input type="submit" value="Выдать промо-коды" style="display: none;" class="btn btn-mini btn-success"/></a></td>
        <td colspan="4"></td>
      </tr>
    </tfoot>
</table>
</form>
<?php else:?>
    <div class="alert">По Вашему запросу нет ни одного участника.</div>
<?php endif;?>

<?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>
