<?php
/**
 * @var $coupons \pay\models\Coupon[]
 */
?>
<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Выдача промо-кодов</h2>
  </div>
</div>

<?if ($error === false):?>
  <form method="POST">
    <?if ($success !== false):?>
      <div class="alert alert-success"><?=$success;?></div>
    <?endif;?>
    <div class="row">
      <div class="span12">
        <label>Укажите кому будет выдан промо-код:</label>
        <textarea class="span6" name="Give[Recipient]"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="span12">
        <input type="submit" value="Выдать" class="btn"/>
      </div>
    </div>
  </form>

  <div class="row">
    <div class="span5">
      <table class="table table-striped">
        <thead>
        <th>Купон</th>
        <th>Скидка</th>
        <th>Статус</th>
        </thead>
        <tbody>
        <?php foreach ($coupons as $coupon):?>
          <tr>
            <td><?php echo  $coupon->Code;?></td>
            <td><?php echo ($coupon->Discount * 100);?>%</td>
            <td>
              <?php if ( empty ($coupon->Recipient)):?>
                <span class="label label-success">Свободен</span>
              <?php else:?>
                <span class="label label-important" title="<?php echo $coupon->Recipient;?>">Выдан</span>
              <?php endif;?>
            </td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
    </div>
  </div>
<?php else:?>
  <div class="alert alert-error">
    <strong>Ошибка!</strong> <?=$error;?>
  </div>
<?php endif; ?>