<ul class="nav nav-pills">
    <li class="active">
        <a href="<?=RouteRegistry::GetUrl('partner', 'coupon', 'index');?>">Промо-коды</a>
    </li>
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'coupon', 'users');?>">Активированные промо-коды</a>
    </li>
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'coupon', 'activation');?>">Активация промо-кода</a>
    </li>
</ul>
<div class="row">
    <div class="span12 indent-bottom3">
        <h2>Выдача промо-кодов</h2>
    </div>
</div>

<?php if ( !isset ($this->Error)):?>
<form method="POST">
<?php if ( isset ($this->Success)):?>
    <div class="alert alert-success"><?php echo $this->Success;?></div>
<?php endif;?>
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
                <?php foreach ($this->Coupons as $coupon):?>
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
        <strong>Ошибка!</strong> <?php echo $this->Error;?>
    </div>
<?php endif; ?>



