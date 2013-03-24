<?php
/**
 * @var $activations \pay\models\CouponActivated[]
 */
?>
<form>
    <div class="row">
        <div class="span4">
            <label>ROCID:</label>
            <input type="text" name="filter[RocId]" value="<?php if ( isset ($filter['RocId'])) echo $filter['RocId'];?>" />
        </div>

        <div class="span4">
            <label>Фамилия, имя:</label>
            <input type="text" name="filter[Name]" value="<?php if ( isset ($filter['Name'])) echo $filter['Name'];?>" />
        </div>

        <div class="span4">
            <label>Код купона:</label>
            <input type="text" name="filter[Code]" value="<?php if ( isset ($filter['Code'])) echo $filter['Code'];?>" />
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <input type="submit" value="Искать" name="" class="btn"/>
        </div>
    </div>
</form>

<?php if (!empty($activations)):?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ROCID</th>
            <th>Ф.И.О.</th>
            <th>Промо-код</th>
            <th>Размер скидки</th>
            <th>Оплачен</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($activations as $activation):?>
            <tr>
                <td><a href="<?php echo $this->createUrl('/partner/user/edit', array('rocId' => $activation->User->RocId));?>"><?php echo $activation->User->RocId;?></a></td>
                <td><?php echo $activation->User->GetFullName();?></td>
                <td><?php echo $activation->Coupon->Code;?></td>
                <td><?php echo $activation->Coupon->Discount * 100;?> %</td>
                <td>
                    <?php if ( !empty ($activation->OrderItems)):?>
                        <span class="label label-success">Оплачен</span>
                    <?php else:?>
                        <span class="label">Не оплачен</span>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php else:?>
    <div class="alert">По Вашему запросу нет ни одной активации.</div>
<?php endif;?>

<?php
$params = array(
  'url' => '/partner/coupon/users',
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