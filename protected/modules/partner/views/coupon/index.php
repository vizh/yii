<?php
/**
 * @var $coupons \pay\models\Coupon[]
 * @var $paginator \application\components\utility\Paginator
 */
?>

<?if (!empty($coupons)):?>
<form action="<?=Yii::app()->createUrl('/partner/coupon/give');?> " method="GET">
<table class="table table-striped">
    <thead>
    <tr>
        <!--<th><input type="checkbox" name="" value="" /></th>-->
        <th>Промо-код</th>
        <th>Скидка</th>
        <th>Продукт</th>
        <th>Выдан</th>
        <th>Активация</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($coupons as $coupon):?>
    <tr>
        <!--<td><input type="checkbox" name="Coupons[]" value="<?=$coupon->Code;?>" /></td>-->
        <td><strong><?=$coupon->Code;?></strong></td>
        <td><strong><?=($coupon->Discount * 100);?> %</strong></td>
        <td>
            <?if ($coupon->ProductId !== null):?>
                <span title="<?=$coupon->Product->Title;?>">
                <?=\application\components\utility\Texts::cropText($coupon->Product->Title, 20);?>
                </span>
            <?else:?>
                &ndash;
            <?endif;?>
        </td>
        <td>
            <?if ($coupon->Recipient == null):?>
                <span class="label">Не выдан</span>
            <?else:?>
                <span class="label label-info">Выдан</span>
          <p>
            <em><?=$coupon->Recipient;?></em>
          </p>
            <?endif;?>
        </td>
        <td>
            <?if (!$coupon->Multiple && sizeof($coupon->Activations) > 0):?>
                <span class="label label-success">Активирован</span> 
                <br/><a target="_blank" href="<?=Yii::app()->createUrl('/user/view/index', array('runetId' => $coupon->Activations[0]->User->RunetId));?>" class="small"><strong><?=$coupon->Activations[0]->User->getFullName();?>, <?=$coupon->Activations[0]->User->RunetId;?></strong></a>
            <?elseif ($coupon->Multiple && sizeof($coupon->Activations) > 0):?>
                <span class="label label-success">
                    Активирован <?=sizeof($coupon->Activations);?> из <?=$coupon->MultipleCount;?>
                </span>
            <?php else:?>
                <span class="label">Не активирован</span>
            <?php endif;?>
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>
   <!-- <tfoot>
    <tr>
      <td></td>
      <td><input type="submit" value="Выдать промо-коды" style="display: none;" class="btn btn-mini btn-success"/></a></td>
      <td colspan="4"></td>
    </tr>
    </tfoot>-->
</table>
</form>
<?php else:?>
    <div class="alert">По Вашему запросу нет ни одного участника.</div>
<?php endif;?>

<?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>
