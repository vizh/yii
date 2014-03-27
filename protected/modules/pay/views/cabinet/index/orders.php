<?php
/**
 * @var $this CabinetController
 * @var $finder \pay\components\collection\Finder
 */
?>
<table class="table">
  <thead>
  <tr>
    <th colspan="4"><h4 class="title"><?=\Yii::t('app', 'Выставленные счета и квитанции');?></h4></th>
  </tr>
  </thead>
  <tbody>
  <?foreach ($finder->getUnpaidOrderCollections() as $collection):?>
      <?if ($collection->getOrder() == null) continue;?>

    <tr>
      <td style="padding-left: 10px; width: 15px;">
        <?if (!$collection->getOrder()->Paid):?>
          <?if (\pay\models\OrderType::getIsBank($collection->getOrder()->Type)):?>
          <?=\CHtml::beginForm(array('/pay/juridical/delete', 'orderId' => $collection->getOrder()->Id), 'post', array('class' => 'button-only'));?>
            <?=\CHtml::htmlButton('<i class="icon-trash"></i>', array('type' => 'submit'));?>
          <?=\CHtml::endForm();?>
          <?elseif ($collection->getOrder()->Type == \pay\models\OrderType::MailRu):?>
            <a  onclick="return confirm('Для удаления счета вы будете направлены на страницу системы Деньги@Mail.Ru');" target="_blank" href="<?=$collection->getOrder()->OrderJuridical->UrlPay;?>"><i class="icon-trash"></i></a>
          <?endif;?>
        <?endif;?>
      </td>
      <td>
        <?=\pay\models\OrderType::getTitle($collection->getOrder()->Type);?> № <?=$collection->getOrder()->Number;?> <?=\Yii::t('app', 'от');?> <?=\Yii::app()->dateFormatter->format('d MMMM yyyy', $collection->getOrder()->CreationTime);?>
      </td>

      <td>
        <?if ($collection->getOrder()->Paid):?>
          <span class="label label-success"><?=Yii::t('app', 'Оплачен');?></span>
        <?endif;?>
      </td>
      <td>
        <a target="_blank" href="<?=$collection->getOrder()->getUrl();?>"><?=\pay\models\OrderType::getTitleViewOrder($collection->getOrder()->Type);?></a>
      </td>
    </tr>
  <?endforeach;?>
  </tbody>
</table>