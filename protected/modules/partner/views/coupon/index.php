<?php
/**
 * @var $coupons \pay\models\Coupon[]
 */
?>
<form method="get">
    <div class="row">
        <div class="span3">
            <label>Диапазон скидки:</label>
            <input type="text" name="filter[Discount][From]" value="<?php if ( isset ($filter['Discount'])) echo $filter['Discount']['From'];?>" class="span1"/><p class="help-inline">&ndash;</p> <input type="text" name="filter[Discount][To]" value="<?php if ( isset ($filter['Discount'])) echo $filter['Discount']['To'];?>" class="span1"/> <p class="help-inline">%</p>
        </div>
        
        <div class="span3">
            <label>Код:</label>
            <input type="text" name="filter[Code]" value="<?php if ( isset ($filter['Code'])) echo $filter['Code'];?>" class="span2" />
        </div>
        
        <div class="span3">
            <label>Выдан:</label>
            <select name="filter[Recipitient]" class="span2">
                <option value="">Все</option>
                <option value="1" <?php if ( isset ($filter['Recipitient']) && $filter['Recipitient'] == 1):?>selected="selected"<?endif;?>>
                    Выдан
                </option>
                <option value="0" <?php if ( isset ($filter['Recipitient']) && $filter['Recipitient'] == 0):?>selected="selected"<?endif;?>>
                    Не выдан
                </option>
            </select>
        </div>
        
        <div class="span3">
            <label>Активация:</label>
            <select name="filter[Activated]" class="span2">
                <option value="">Все</option>
                <option value="1" <?php if ( isset ($filter['Activated']) && $filter['Activated'] == 1):?>selected="selected"<?endif;?>>Активирован</option>
                <option value="0" <?php if ( isset ($filter['Activated']) && $filter['Activated'] == 0):?>selected="selected"<?endif;?>>Не активирован</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="span12"><input type="submit" value="Искать" name="" class="btn" /></div>
    </div>
</form>

<?php if (!empty($coupons)):?>
<form action="/partner/coupon/give/" method="GET">
<table class="table table-striped">
    <thead>
    <tr>
        <th><input type="checkbox" name="" value="" /></th>
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
        <td><input type="checkbox" name="Coupons[]" value="<?php echo $coupon->Code;?>" /></td>
        <td><h3><?php echo $coupon->Code;?></h3></td>
        <td>
            <h3><?php echo ($coupon->Discount * 100);?> %</h3>
        </td>
        <td>
            <?php if ($coupon->ProductId !== null):?>
                <span title="<?php echo $coupon->Product->Title;?>">
                <?php 
                    echo mb_strlen ($coupon->Product->Title, 'utf-8') > 20 
                            ? mb_substr ($coupon->Product->Title, 0, 20, 'utf-8').'...' : $coupon->Product->Title;
                ?>
                </span>
            <?php else:?>
                &ndash;
            <?php endif;?>
        </td>
        <td>
            <?php if ($coupon->Recipient == null):?>
                <span class="label">Не выдан</span>
            <?php else:?>
                <span class="label label-info">Выдан</span>
          <p>
            <em><?=$coupon->Recipient;?></em>
          </p>
            <?php endif;?>
        </td>
        <td>
            <?php if ($coupon->Multiple == 0 
                    && $coupon->CouponActivatedList != null):?>
                <span class="label label-success">Активирован</span>
            <?php elseif ($coupon->Multiple > 0
                    && sizeof ($coupon->CouponActivatedList) > 0):?>
                <span class="label label-success">
                    Активирован <?php echo sizeof ($coupon->CouponActivatedList);?> из <?php echo $coupon->Multiple;?>
                </span>
            <?php else:?>
                <span class="label">Не активирован</span>
            <?php endif;?>
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
        <td></td>
        <td><input type="submit" value="Выдать промо-коды" style="display: none;" class="btn btn-mini btn-success"/></a></td>
        <td colspan="4"></td>
    </tfoot>
</table>
</form>
<?php else:?>
    <div class="alert">По Вашему запросу нет ни одного участника.</div>
<?php endif;?>

<?php
$params = array(
  'url' => '/partner/coupon/index',
  'count' => $count,
  'perPage' => CouponController::CouponOnPage,
  'page' => $page
);
if (!empty($filter))
{
  $params['params'] = array('filter' => $filter);
}

$this->widget('\application\widgets\Paginator', $params);
?>
